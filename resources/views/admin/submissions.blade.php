@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>All Form Submissions</h2>
            <p class="lead">Review and manage housing scheme applications</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Housing Applications</h5>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($submissions) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Applicant</th>
                                        <th>Details</th>
                                        <th>Document</th>
                                        <th>Income</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $submission)
                                    <tr>
                                        <td>{{ $submission->id }}</td>
                                        <td>
                                            <div><strong>{{ $submission->name }}</strong></div>
                                            <small class="text-muted">{{ $submission->user->email }}</small>
                                        </td>
                                        <td>
                                            <div><strong>Address:</strong> {{ Str::limit($submission->address, 30) }}</div>
                                            <div><strong>Aadhar:</strong> {{ $submission->aadhar_number }}</div>
                                            <div><strong>Tracking ID:</strong> {{ $submission->tracking_id }}</div>
                                            @if($submission->message)
                                                <button type="button" class="btn btn-sm btn-outline-secondary mt-1" 
                                                    data-bs-toggle="modal" data-bs-target="#messageModal{{ $submission->id }}">
                                                    View Message
                                                </button>
                                                
                                                <!-- Message Modal -->
                                                <div class="modal fade" id="messageModal{{ $submission->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Applicant's Message</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $submission->message }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($submission->status == 'rejected' && $submission->rejection_reason)
                                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectionModal{{ $submission->id }}">
                                                    View Reason
                                                </button>
                                                
                                                <!-- Rejection Reason Modal -->
                                                <div class="modal fade" id="rejectionModal{{ $submission->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">Rejection Reason</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $submission->rejection_reason }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->document_path)
                                                <div>
                                                    <strong>Type:</strong> 
                                                    @if($submission->document_type == 'aadhar_card')
                                                        Aadhar Card
                                                    @elseif($submission->document_type == 'pan_card')
                                                        PAN Card
                                                    @elseif($submission->document_type == 'driving_license')
                                                        Driving License
                                                    @elseif($submission->document_type == 'income_certificate')
                                                        Income Certificate
                                                    @else
                                                        {{ $submission->document_type }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.view-document', $submission->id) }}" 
                                                       class="btn btn-sm btn-info mt-1" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> View Document
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-muted">No document</span>
                                            @endif
                                        </td>
                                        <td>₹{{ number_format($submission->annual_income, 2) }}</td>
                                        <td>{{ $submission->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @if($submission->status == 'pending')
                                                <span class="badge status-badge status-pending">Pending</span>
                                            @elseif($submission->status == 'accepted')
                                                <span class="badge status-badge status-accepted">Accepted</span>
                                            @else
                                                <span class="badge status-badge status-rejected">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->status == 'pending')
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.accept-form', $submission->id) }}" 
                                                       class="btn btn-success btn-sm" 
                                                       onclick="return confirm('Are you sure you want to accept this application?')">
                                                        Accept
                                                    </a>
                                                    <a href="{{ route('admin.show-reject-form', $submission->id) }}" 
                                                       class="btn btn-danger btn-sm">
                                                        Reject
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-muted">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No form submissions found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 