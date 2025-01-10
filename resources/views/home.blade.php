@extends('layouts.app')

@section('content')
  <div class="container">
    <!-- Search & Filter Section -->
    <div class="card mb-4">
      <div class="card-body">
        <form action="{{ route('home') }}" class="row g-3" method="GET">
          <!-- Gender Filter -->
          <div class="col-md-3">
            <label class="form-label">{{ __('Filter by Gender') }}</label>
            <select class="form-select" name="gender">
              <option value="">All</option>
              <option {{ request('gender') == 'male' ? 'selected' : '' }} value="male">Male</option>
              <option {{ request('gender') == 'female' ? 'selected' : '' }} value="female">Female</option>
            </select>
          </div>

          <!-- Hobby/Work Field Search -->
          <div class="col-md-7">
            <label class="form-label">{{ __('Search by Hobby/Work Field') }}</label>
            <input class="form-control" name="search" placeholder="Search hobbies or work fields..." type="text"
              value="{{ request('search') }}">
          </div>

          <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100" type="submit">
              {{ __('Search') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Users Grid -->
    <div class="row">
      @foreach ($users as $user)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <!-- User Avatar -->
            <img alt="Avatar" class="card-img-top" src="{{ $user->avatar_path ?? asset('images/default-avatar.jpg') }}"
              style="height: 200px; object-fit: cover;">

            <div class="card-body">
              <h5 class="card-title">{{ $user->name }}</h5>

              <!-- Hobbies -->
              @if ($user->hobbies->isNotEmpty())
                <p class="card-text">
                  <strong>Hobbies:</strong><br>
                  {{ $user->hobbies->pluck('name')->join(', ') }}
                </p>
              @endif

              <!-- Work Fields -->
              @if ($user->workFields->isNotEmpty())
                <p class="card-text">
                  <strong>Work Fields:</strong><br>
                  {{ $user->workFields->pluck('name')->join(', ') }}
                </p>
              @endif

              <!-- Like/Thumb Button -->
              <form action="{{ route('friends.request', $user->id) }}" class="mt-3" method="POST">
                @csrf
                <button class="btn btn-outline-primary" type="submit">
                  <i class="bi bi-hand-thumbs-up"></i> Like
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $users->links() }}
    </div>

    @if ($users->isEmpty())
      <div class="mt-4 text-center">
        <p>No users found.</p>
      </div>
    @endif
  </div>
@endsection

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
@endpush
