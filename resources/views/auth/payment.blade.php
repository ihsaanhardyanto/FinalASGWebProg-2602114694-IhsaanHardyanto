@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registration Payment') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.payment') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">{{ __('Registration Fee') }}</label>
                            <div class="form-control bg-light">
                                Rp. {{ number_format($registrationFee, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Payment Amount') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" value="{{ old('amount', $registrationFee) }}" 
                                       required min="{{ $registrationFee }}">
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                {{ __('Note: If you pay more than the registration fee, the excess amount will be added to your balance.') }}
                            </small>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Process Payment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection