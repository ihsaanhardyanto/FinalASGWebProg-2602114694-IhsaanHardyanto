<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        $users = User::where('is_visible', true)->latest()->take(10)->get();
        return view('welcome', compact('users'));
    }

    public function index(Request $request)
    {
        $query = User::where('is_visible', true)
            ->where('id', '!=', Auth::id());

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Search by hobby or work field
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('hobbies', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('workFields', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('home', compact('users'));
    }
}