@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('Gender') }}</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" 
                                           id="gender-male" value="male" required 
                                           {{ old('gender') === 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender-male">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" 
                                           id="gender-female" value="female" required
                                           {{ old('gender') === 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender-female">{{ __('Female') }}</label>
                                </div>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">{{ __('Mobile Number') }}</label>
                            <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" 
                                   name="mobile_number" value="{{ old('mobile_number') }}" required>
                            @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Social Link (Instagram/LinkedIn) -->
                        <div class="mb-3">
                            <label for="social_link" class="form-label">{{ __('Social Media Link') }}</label>
                            <input id="social_link" type="url" class="form-control @error('social_link') is-invalid @enderror" 
                                   name="social_link" value="{{ old('social_link') }}" required
                                   placeholder="https://instagram.com/username or https://linkedin.com/in/username">
                            @error('social_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Hobbies (Min 3) -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('Hobbies (Select at least 3)') }}</label>
                            <div class="row">
                                @foreach($hobbies as $hobby)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="hobbies[]" value="{{ $hobby->id }}"
                                                   id="hobby-{{ $hobby->id }}"
                                                   {{ (old('hobbies') && in_array($hobby->id, old('hobbies'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hobby-{{ $hobby->id }}">
                                                {{ $hobby->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('hobbies')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <!-- Registration Fee -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('Registration Fee') }}</label>
                            <div class="form-control bg-light">
                                Rp. {{ number_format($registrationFee, 0, ',', '.') }}
                            </div>
                            <input type="hidden" name="registration_fee" value="{{ $registrationFee }}">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection