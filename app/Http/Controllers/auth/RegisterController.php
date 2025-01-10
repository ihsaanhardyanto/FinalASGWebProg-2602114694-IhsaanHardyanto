<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hobby;
use App\Models\WorkField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $hobbies = Hobby::all();
        $workFields = WorkField::all();
        $registrationFee = rand(100000, 125000);
        return view('auth.register', compact('hobbies', 'workFields', 'registrationFee'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female',
            'mobile_number' => 'required|numeric',
            'social_link' => 'required|url',
            'hobbies' => 'required|array|min:3',
            'registration_fee' => 'required|numeric|min:100000|max:125000'
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'gender' => $validated['gender'],
                'mobile_number' => $validated['mobile_number'],
                'social_link' => $validated['social_link'],
                'balance' => 0,
                'is_visible' => true,
            ]);

            // Attach hobbies
            if ($request->has('hobbies')) {
                $user->hobbies()->attach($request->hobbies);
            }

            DB::commit();

            // Store user_id in session for payment process
            session(['registration_user_id' => $user->id]);
            session(['registration_fee' => $validated['registration_fee']]);

            return redirect()->route('register.payment');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Registration failed. ' . $e->getMessage()]);
        }
    }

    public function showPaymentForm()
    {
        // Get registration fee from session
        $registrationFee = session('registration_fee');
        $userId = session('registration_user_id');

        if (!$registrationFee || !$userId) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Please complete registration first']);
        }

        return view('auth.payment', compact('registrationFee', 'userId'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);

        $userId = session('registration_user_id');
        $registrationFee = session('registration_fee');

        if (!$userId || !$registrationFee) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Invalid session. Please register again.']);
        }

        try {
            DB::beginTransaction();

            $user = User::findOrFail($userId);
            $amount = $validated['amount'];

            // Check if amount is less than registration fee
            if ($amount < $registrationFee) {
                $underpaid = $registrationFee - $amount;
                return back()->withErrors([
                    'amount' => "You are still underpaid Rp. " . number_format($underpaid, 0, ',', '.')
                ]);
            }

            // Check if amount is more than registration fee
            if ($amount > $registrationFee) {
                $overpaid = $amount - $registrationFee;
                // Add overpaid amount to user balance
                $user->balance += $overpaid;
                $user->save();
            }

            // Create transaction record
            $user->transactions()->create([
                'amount' => $registrationFee,
                'type' => 'registration',
                'status' => 'completed'
            ]);

            DB::commit();

            // Clear registration session
            session()->forget(['registration_user_id', 'registration_fee']);

            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Payment failed. ' . $e->getMessage()]);
        }
    }
}