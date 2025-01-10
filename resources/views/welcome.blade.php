@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Welcome to ConnectFriend</h1>
        <p class="lead">Find friends with similar interests and connect with them!</p>
        
        @guest
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary mx-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary mx-2">Register</a>
            </div>
        @endguest
        
        @if($users->count() > 0)
            <div class="row mt-5">
                <h2>Our Latest Members</h2>
                @foreach($users as $user)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ $user->avatar_path ?? 'default-avatar.jpg' }}" 
                                 class="card-img-top" alt="Avatar">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text">
                                    @if($user->hobbies->count() > 0)
                                        Hobbies: {{ $user->hobbies->pluck('name')->join(', ') }}
                                    @endif
                                    
                                    @if($user->workFields->count() > 0)
                                        Fields: {{ $user->workFields->pluck('name')->join(', ') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection