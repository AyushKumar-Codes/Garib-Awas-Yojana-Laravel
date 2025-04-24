@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Application Details</h2>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Application #{{ $submission->id }} - {{ $submission->name }}</h5>
                        <span class="badge 
                            @if($submission->status == 'pending') bg-warning text-dark
                            @elseif($submission->status == 'accepted') bg-success
                            @else bg-danger @endif">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Tracking ID</th>
                                    <td><strong>{{ $submission->tracking_id }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Applicant Name</th>
                                    <td>{{ $submission->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $submission->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $submission->address }}</td>
                                </tr>
                                <tr>
                                    <th>Aadhar Number</th>
                                    <td>{{ $submission->aadhar_number }}</td>
                                </tr>
                                <tr>
                                    <th>Annual Income</th>
                                    <td>₹{{ number_format($submission->annual_income, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td>
                                        @if($submission->document_type == 'aadhar_card')
                                            Aadhar Card
                                        @elseif($submission->document_type == 'pan_card')
                                            PAN Card
                                        @elseif($submission->document_type == 'driving_license')
                                            Driving License
                                        @elseif($submission->document_type == 'income_certificate')
                                            Income Certificate
                                        @else
                                            {{ $submission->document_type ?? 'Not specified' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Submitted On</th>
                                    <td>{{ $submission->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $submission->updated_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                @if($submission->status == 'rejected' && $submission->rejection_reason)
                                <tr>
                                    <th>Rejection Reason</th>
                                    <td class="text-danger">{{ $submission->rejection_reason }}</td>
                                </tr>
                                @endif
                                @if($submission->message)
                                <tr>
                                    <th>Applicant's Message</th>
                                    <td>{{ $submission->message }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Document</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($submission->document_path)
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                        </div>
                                        <p><strong>{{ $submission->document_original_name ?? 'Document' }}</strong></p>
                                        <a href="{{ route('admin.view-document', $submission->id) }}" 
                                           class="btn btn-primary" target="_blank">
                                            <i class="fas fa-eye"></i> View Document
                                        </a>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> No document available
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($submission->status == 'pending')
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.accept-form', $submission->id) }}" 
                                           class="btn btn-success" 
                                           onclick="return confirm('Are you sure you want to accept this application?')">
                                            <i class="fas fa-check"></i> Accept Application
                                        </a>
                                        <a href="{{ route('admin.show-reject-form', $submission->id) }}" 
                                           class="btn btn-danger">
                                            <i class="fas fa-times"></i> Reject Application
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 