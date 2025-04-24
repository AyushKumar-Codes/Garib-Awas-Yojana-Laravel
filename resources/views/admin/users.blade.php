@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Registered Users</h2>
            <p class="lead">View all users and their application details</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Management</h5>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($users) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registered On</th>
                                        <th>Applications</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @php
                                                $pendingCount = $user->formSubmissions->where('status', 'pending')->count();
                                                $acceptedCount = $user->formSubmissions->where('status', 'accepted')->count();
                                                $rejectedCount = $user->formSubmissions->where('status', 'rejected')->count();
                                                $totalCount = $user->formSubmissions->count();
                                            @endphp
                                            
                                            @if($totalCount > 0)
                                                <div>Total: {{ $totalCount }}</div>
                                                
                                                @if($pendingCount > 0)
                                                    <span class="badge status-badge status-pending">{{ $pendingCount }} Pending</span>
                                                @endif
                                                
                                                @if($acceptedCount > 0)
                                                    <span class="badge status-badge status-accepted">{{ $acceptedCount }} Accepted</span>
                                                @endif
                                                
                                                @if($rejectedCount > 0)
                                                    <span class="badge status-badge status-rejected">{{ $rejectedCount }} Rejected</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No applications</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">
                                                View Details
                                            </button>
                                            
                                            <!-- User Details Modal -->
                                            <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">User Details: {{ $user->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <p><strong>Name:</strong> {{ $user->name }}</p>
                                                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                    <p><strong>User ID:</strong> {{ $user->id }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Registration Date:</strong> {{ $user->created_at->format('d F, Y') }}</p>
                                                                    <p><strong>Total Applications:</strong> {{ $totalCount }}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <h6 class="border-bottom pb-2 mb-3">Application History</h6>
                                                            
                                                            @if(count($user->formSubmissions) > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Submission Date</th>
                                                                                <th>Income</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($user->formSubmissions as $submission)
                                                                            <tr>
                                                                                <td>{{ $submission->id }}</td>
                                                                                <td>{{ $submission->created_at->format('d M, Y') }}</td>
                                                                                <td>₹{{ number_format($submission->annual_income, 2) }}</td>
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
                                                                                            class="btn btn-success btn-sm">Accept</a>
                                                                                            <a href="{{ route('admin.reject-form', $submission->id) }}" 
                                                                                            class="btn btn-danger btn-sm">Reject</a>
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
                                                                    This user has not submitted any applications yet.
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No users found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 