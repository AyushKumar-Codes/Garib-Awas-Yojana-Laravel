@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Reject Application</h2>
            <p class="lead">Please provide a reason for rejecting this application</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Application #{{ $submission->id }} - {{ $submission->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Applicant Details</h6>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $submission->name }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $submission->address }}</td>
                                </tr>
                                <tr>
                                    <th>Aadhar Number:</th>
                                    <td>{{ $submission->aadhar_number }}</td>
                                </tr>
                                <tr>
                                    <th>Annual Income:</th>
                                    <td>₹{{ number_format($submission->annual_income, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Application Message</h6>
                            <div class="card">
                                <div class="card-body bg-light">
                                    {{ $submission->message ?: 'No message provided.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.reject-form', $submission->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="rejection_reason" class="form-label">Rejection Reason:</label>
                            <textarea class="form-control @error('rejection_reason') is-invalid @enderror" 
                                id="rejection_reason" 
                                name="rejection_reason" 
                                rows="5" 
                                required>{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Please provide a clear reason why this application is being rejected. 
                                This will be visible to the applicant.
                            </small>
                        </div>
                        
                        <div class="d-flex mt-4">
                            <button type="submit" class="btn btn-danger me-3">Reject Application</button>
                            <a href="{{ route('admin.submissions') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 