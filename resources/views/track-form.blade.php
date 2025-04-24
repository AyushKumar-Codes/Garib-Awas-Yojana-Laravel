@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Track Your Application</h4>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('track.application') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="tracking_id">Application Tracking ID</label>
                            <input id="tracking_id" type="text" class="form-control @error('tracking_id') is-invalid @enderror" 
                                name="tracking_id" value="{{ old('tracking_id') }}" required autocomplete="off" autofocus>
                            
                            @error('tracking_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <small class="form-text text-muted">
                                Enter the tracking ID that was provided to you after submitting your application or in the confirmation email.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Track Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 