@extends('layouts.app')

@section('additional_styles')
<style>
    .dashboard-header {
        background: linear-gradient(to right, var(--primary-color), var(--dark-blue));
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .dashboard-stats-item {
        background-color: white;
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    
    .dashboard-stats-item:hover {
        transform: translateY(-5px);
    }
    
    .scheme-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
    }
    
    .scheme-card:hover {
        transform: translateY(-5px);
    }
    
    .scheme-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }
    
    .scheme-img {
        height: 160px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .bg-light-blue {
        background-color: var(--light-blue);
    }
    
    .application-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 30px;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--primary-color);
        z-index: 1;
    }
    
    .timeline-item:after {
        content: '';
        position: absolute;
        left: -21px;
        top: 20px;
        width: 2px;
        height: calc(100% - 20px);
        background-color: #dee2e6;
    }
    
    .timeline-item:last-child:after {
        display: none;
    }
    
    .timeline-item.active:before {
        background-color: #198754;
    }
    
    .timeline-item.pending:before {
        background-color: #ffc107;
    }
    
    .timeline-item.rejected:before {
        background-color: #dc3545;
    }
    
    .timeline-content {
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .application-status {
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    
    .status-accepted {
        background-color: rgba(25, 135, 84, 0.1);
        border-left: 4px solid #198754;
    }
    
    .status-pending {
        background-color: rgba(255, 193, 7, 0.1);
        border-left: 4px solid #ffc107;
    }
    
    .status-rejected {
        background-color: rgba(220, 53, 69, 0.1);
        border-left: 4px solid #dc3545;
    }
    
    .apply-now-card {
        background: linear-gradient(45deg, var(--primary-color), var(--dark-blue));
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .quick-action-btn {
        transition: all 0.3s;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-3px);
    }
</style>
@endsection

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h2 class="mb-2">Welcome, {{ Auth::user()->name }}</h2>
                <p class="mb-0">Manage your housing applications and track their status</p>
            </div>
            <div class="col-md-5">
                <div class="row">
                    @php
                        $activeSubmissions = $submissions->whereIn('status', ['pending', 'accepted'])->count();
                        $remainingSlots = 5 - $activeSubmissions;
                    @endphp
                    <div class="col-6">
                        <div class="dashboard-stats-item text-center">
                            <h4 class="text-primary mb-0">{{ $activeSubmissions }}</h4>
                            <p class="mb-0 text-muted">Active Applications</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="dashboard-stats-item text-center">
                            <h4 class="text-success mb-0">{{ $remainingSlots }}</h4>
                            <p class="mb-0 text-muted">Remaining Slots</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100 quick-action-btn">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-2x text-primary mb-3"></i>
                    <h5>View Schemes</h5>
                    <p class="text-muted">Explore available housing schemes</p>
                    <a href="#available-schemes" class="btn btn-outline-primary">View Schemes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100 quick-action-btn">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-2x text-success mb-3"></i>
                    <h5>Apply Now</h5>
                    <p class="text-muted">Submit a new housing application</p>
                    @if($remainingSlots > 0)
                        <a href="{{ route('form') }}" class="btn btn-success">Apply Now</a>
                    @else
                        <button class="btn btn-secondary" disabled>Maximum Limit Reached</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 quick-action-btn">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-warning mb-3"></i>
                    <h5>Track Status</h5>
                    <p class="text-muted">Check your application status</p>
                    <a href="#my-applications" class="btn btn-outline-warning">Track Status</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- My Applications Section -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card" id="my-applications">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">My Applications</h5>
                </div>
                <div class="card-body">
                    @if(count($submissions) > 0)
                        @foreach($submissions as $submission)
                            <div class="application-status 
                                @if($submission->status == 'pending') status-pending 
                                @elseif($submission->status == 'accepted') status-accepted 
                                @else status-rejected @endif">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6 class="mb-1">Application #{{ $submission->id }}</h6>
                                        <p class="mb-0 text-muted fs-6">{{ $submission->created_at->format('d M, Y') }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="mb-1"><strong>Name:</strong> {{ $submission->name }}</p>
                                        <p class="mb-0"><strong>Aadhar:</strong> {{ $submission->aadhar_number }}</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        @if($submission->status == 'pending')
                                            <span class="badge bg-warning text-dark mb-2 d-block d-md-inline-block">Pending</span>
                                            <small class="d-block text-muted">Under review</small>
                                        @elseif($submission->status == 'accepted')
                                            <span class="badge bg-success mb-2 d-block d-md-inline-block">Accepted</span>
                                            <small class="d-block text-muted">Congratulations!</small>
                                        @else
                                            <span class="badge bg-danger mb-2 d-block d-md-inline-block">Rejected</span>
                                            @if($submission->rejection_reason)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="mt-4 application-timeline">
                            <h6 class="mb-4">Application Timeline</h6>
                            
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h6>Application Submitted</h6>
                                    <p class="mb-0 text-muted">Your application has been submitted successfully</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item active">
                                <div class="timeline-content">
                                    <h6>Verification Process</h6>
                                    <p class="mb-0 text-muted">Application documents are being verified</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item pending">
                                <div class="timeline-content">
                                    <h6>Eligibility Assessment</h6>
                                    <p class="mb-0 text-muted">Checking eligibility criteria</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <h6>Financial Assistance</h6>
                                    <p class="mb-0 text-muted">Financial assistance will be processed</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <h6>Housing Construction</h6>
                                    <p class="mb-0 text-muted">Construction of your housing will begin</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center p-4">
                            <img src="https://img.icons8.com/clouds/200/000000/home.png" alt="No Applications" class="mb-3">
                            <h5>No Applications Yet</h5>
                            <p class="text-muted mb-4">You haven't submitted any housing applications yet.</p>
                            <a href="{{ route('form') }}" class="btn btn-primary">Apply Now</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Apply Now Card -->
            <div class="apply-now-card">
                <h5>Ready to Apply?</h5>
                <p>You can submit up to {{ $remainingSlots }} more applications.</p>
                @if($remainingSlots > 0)
                    <a href="{{ route('form') }}" class="btn btn-light">Apply Now</a>
                @else
                    <button class="btn btn-light" disabled>Maximum Limit Reached</button>
                @endif
            </div>
            
            <!-- Important Updates -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Important Updates</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-3"></i>
                            <div>
                                <p class="mb-0">Next document verification camp on May 10, 2025</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-bell text-warning me-3"></i>
                            <div>
                                <p class="mb-0">Update your Aadhar details before applying</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-success me-3"></i>
                            <div>
                                <p class="mb-0">Last date for Phase II applications: June 30, 2025</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Help Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <p>Contact our support team for assistance</p>
                    <div class="d-flex mb-3">
                        <i class="fas fa-phone text-info me-3 mt-1"></i>
                        <div>
                            <p class="mb-0">Helpline</p>
                            <h6>1800-123-4567</h6>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class="fas fa-envelope text-info me-3 mt-1"></i>
                        <div>
                            <p class="mb-0">Email</p>
                            <h6>support@ruralmis.gov.in</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Available Schemes Section -->
    <h3 class="mt-5 mb-4" id="available-schemes">Available Housing Schemes</h3>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card scheme-card">
                <span class="badge bg-success scheme-badge">Popular</span>
                <img src="https://images.unsplash.com/photo-1572120360610-d971b9d7767c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="scheme-img" alt="Housing Scheme 1">
                <div class="card-body">
                    <h5 class="card-title">Pradhan Mantri Awaas Yojana - Gramin</h5>
                    <p class="card-text">Providing assistance for construction of houses to eligible homeless families in rural areas.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-success"><strong>₹1,20,000</strong> assistance</span>
                        <a href="{{ route('form') }}" class="btn btn-sm btn-primary">Apply</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card scheme-card">
                <img src="https://images.unsplash.com/photo-1523217582562-09d0def993a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="scheme-img" alt="Housing Scheme 2">
                <div class="card-body">
                    <h5 class="card-title">Credit Linked Subsidy Scheme</h5>
                    <p class="card-text">Interest subsidy on home loans taken by eligible applicants for acquisition/construction of houses.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-success"><strong>6.5%</strong> interest subsidy</span>
                        <a href="{{ route('form') }}" class="btn btn-sm btn-primary">Apply</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card scheme-card">
                <span class="badge bg-primary scheme-badge">New</span>
                <img src="https://images.unsplash.com/photo-1531971589569-0d9370cbe1e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="scheme-img" alt="Housing Scheme 3">
                <div class="card-body">
                    <h5 class="card-title">Rural Housing Interest Subsidy</h5>
                    <p class="card-text">Subsidizing interest for rural housing to make it more affordable for people in rural areas.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-success"><strong>₹75,000</strong> subsidy</span>
                        <a href="{{ route('form') }}" class="btn btn-sm btn-primary">Apply</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Previous Schemes Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light-blue">
                <div class="card-body">
                    <h4 class="mb-4">Previous Housing Schemes</h4>
                    <div class="row">
                        @foreach($previousSchemes as $scheme)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $scheme['name'] }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Launched: {{ $scheme['launch_year'] }}</h6>
                                        <p class="card-text">{{ $scheme['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
