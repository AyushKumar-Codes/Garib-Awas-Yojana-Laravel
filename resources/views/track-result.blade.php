@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Application Status</h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Tracking ID:</strong> {{ $formSubmission->tracking_id }}
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Application Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $formSubmission->name }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $formSubmission->address }}</td>
                                </tr>
                                <tr>
                                    <th>Submitted On</th>
                                    <td>{{ $formSubmission->created_at->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td>
                                        @if($formSubmission->document_type == 'aadhar_card')
                                            Aadhar Card
                                        @elseif($formSubmission->document_type == 'pan_card')
                                            PAN Card
                                        @elseif($formSubmission->document_type == 'driving_license')
                                            Driving License
                                        @elseif($formSubmission->document_type == 'income_certificate')
                                            Income Certificate
                                        @else
                                            {{ $formSubmission->document_type ?? 'Not specified' }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Status Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Current Status</th>
                                    <td>
                                        @if($formSubmission->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending Review</span>
                                        @elseif($formSubmission->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($formSubmission->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($formSubmission->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $formSubmission->updated_at->format('F d, Y') }}</td>
                                </tr>
                                @if($formSubmission->status == 'rejected' && $formSubmission->rejection_reason)
                                <tr>
                                    <th>Rejection Reason</th>
                                    <td>{{ $formSubmission->rejection_reason }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($formSubmission->status == 'pending')
                        <div class="alert alert-warning">
                            <p><i class="fas fa-info-circle"></i> Your application is currently under review. Please check back later for updates.</p>
                        </div>
                    @elseif($formSubmission->status == 'accepted')
                        <div class="alert alert-success">
                            <p><i class="fas fa-check-circle"></i> Congratulations! Your application has been accepted. Our team will contact you soon with further instructions.</p>
                        </div>
                    @elseif($formSubmission->status == 'rejected')
                        <div class="alert alert-danger">
                            <p><i class="fas fa-exclamation-circle"></i> We regret to inform you that your application has been rejected. Please refer to the rejection reason above for more details.</p>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('track.form') }}" class="btn btn-secondary">Track Another Application</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 