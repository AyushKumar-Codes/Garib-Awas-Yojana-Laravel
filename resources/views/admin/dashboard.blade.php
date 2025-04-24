@extends('layouts.admin')

@section('additional_styles')
<style>
    .admin-stats {
        transition: all 0.3s;
    }
    
    .admin-stats:hover {
        transform: translateY(-5px);
    }
    
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        height: 100%;
    }
    
    .stat-card .card-body {
        padding: 15px;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .stat-primary {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
    }
    
    .stat-success {
        background: linear-gradient(45deg, #198754, #157347);
    }
    
    .stat-warning {
        background: linear-gradient(45deg, #ffc107, #e5ac00);
    }
    
    .stat-danger {
        background: linear-gradient(45deg, #dc3545, #bb2d3b);
    }
    
    .stat-info {
        background: linear-gradient(45deg, #0dcaf0, #0aa2c0);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .admin-table {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .admin-table thead th {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }
    
    .admin-table tbody td {
        vertical-align: middle;
    }
    
    .quick-action-card {
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
    }
    
    .activity-item {
        padding: 15px;
        border-left: 3px solid #dee2e6;
        margin-bottom: 15px;
        background-color: #f8f9fa;
        border-radius: 0 10px 10px 0;
        transition: all 0.3s;
    }
    
    .activity-item:hover {
        border-left-color: var(--primary-color);
        background-color: var(--light-blue);
    }
    
    .status-count {
        font-weight: 700;
        font-size: 2rem;
    }
    
    .status-label {
        font-weight: 600;
        font-size: 1rem;
        color: #6c757d;
    }
    
    .map-container {
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2>Admin Dashboard</h2>
            <p class="lead mb-0">Welcome to the Rural Housing MIS Admin Panel</p>
        </div>
        <div class="col-md-6 text-md-end">
            <span class="text-muted">Last Updated: {{ now()->format('d M, Y, g:i A') }}</span>
        </div>
    </div>
    
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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="admin-stats">
                <div class="card stat-card text-white stat-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt stat-icon"></i>
                        <h2 class="mb-1">{{ $totalSubmissions }}</h2>
                        <p class="mb-0">Total Submissions</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="admin-stats">
                <div class="card stat-card text-white stat-warning">
                    <div class="card-body text-center">
                        <i class="fas fa-spinner stat-icon"></i>
                        <h2 class="mb-1">{{ $pendingSubmissions }}</h2>
                        <p class="mb-0">Pending Applications</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="admin-stats">
                <div class="card stat-card text-white stat-success">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle stat-icon"></i>
                        <h2 class="mb-1">{{ $acceptedSubmissions }}</h2>
                        <p class="mb-0">Accepted Applications</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="admin-stats">
                <div class="card stat-card text-white stat-danger">
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle stat-icon"></i>
                        <h2 class="mb-1">{{ $rejectedSubmissions }}</h2>
                        <p class="mb-0">Rejected Applications</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Unread Messages -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="admin-stats">
                <div class="card stat-card text-white stat-info">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-envelope stat-icon d-inline-block me-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-0">You have {{ $unreadContacts }} unread contact {{ $unreadContacts == 1 ? 'message' : 'messages' }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-light">View Messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Action & User Stats -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.submissions') }}" class="text-decoration-none">
                                <div class="card quick-action-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clipboard-list text-primary fa-2x mb-2"></i>
                                        <h5>View Submissions</h5>
                                        <p class="text-muted mb-0">Manage all applications</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                                <div class="card quick-action-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users text-success fa-2x mb-2"></i>
                                        <h5>Manage Users</h5>
                                        <p class="text-muted mb-0">View and manage users</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('admin.contacts.index') }}" class="text-decoration-none">
                                <div class="card quick-action-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope text-info fa-2x mb-2"></i>
                                        <h5>Contact Messages</h5>
                                        <p class="text-muted mb-0">
                                            <span class="badge bg-{{ $unreadContacts > 0 ? 'danger' : 'success' }} rounded-pill">
                                                {{ $unreadContacts }} Unread
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}" class="text-decoration-none">
                                <div class="card quick-action-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-download text-warning fa-2x mb-2"></i>
                                        <h5>Generate Reports</h5>
                                        <p class="text-muted mb-0">Download analytics</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scheme Distribution -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Application Distribution by District</h5>
                </div>
                <div class="card-body">
                    <div class="map-container">
                        <div id="map" style="height: 100%; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">User Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <strong>Total Users</strong>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="mb-0">{{ $totalUsers }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <strong>Active Users</strong>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="mb-0">{{ round($totalUsers * 0.82) }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <strong>New This Month</strong>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="mb-0">{{ round($totalUsers * 0.24) }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 24%" aria-valuenow="24" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">View All Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reports & Activity Log -->
    <div class="row mb-4">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card" id="reports">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application Reports</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Download Report
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.reports.download.all') }}"><i class="fas fa-file-csv me-2"></i>All Applications</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.download.status', 'pending') }}"><i class="fas fa-file-csv me-2"></i>Pending Applications</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.download.status', 'accepted') }}"><i class="fas fa-file-csv me-2"></i>Accepted Applications</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.download.status', 'rejected') }}"><i class="fas fa-file-csv me-2"></i>Rejected Applications</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports') }}"><i class="fas fa-chart-bar me-2"></i>View All Reports</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="status-count text-primary">{{ $pendingSubmissions }}</div>
                            <div class="status-label">Pending</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="status-count text-success">{{ $acceptedSubmissions }}</div>
                            <div class="status-label">Accepted</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="status-count text-danger">{{ $rejectedSubmissions }}</div>
                            <div class="status-label">Rejected</div>
                        </div>
                    </div>
                    
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        @foreach($recentApplications as $application)
                        <div class="activity-item">
                            <div class="d-flex mb-2">
                                <strong>
                                    @if($application->status == 'pending')
                                        New Submission
                                    @elseif($application->status == 'accepted')
                                        Form Approved
                                    @elseif($application->status == 'rejected')
                                        Form Rejected
                                    @endif
                                </strong>
                                <small class="ms-auto text-muted">{{ $application->updated_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0">
                                @if($application->status == 'pending')
                                    {{ $application->name }} submitted a new housing application
                                @elseif($application->status == 'accepted')
                                    Application #{{ $application->id }} from {{ $application->name }} was approved
                                @elseif($application->status == 'rejected')
                                    Application #{{ $application->id }} from {{ $application->name }} was rejected
                                @endif
                            </p>
                        </div>
                        @endforeach
                        
                        @if(count($recentApplications) == 0)
                        <div class="p-3 text-center">
                            <p class="mb-0">No recent activity found</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-sm btn-outline-primary w-100">View All Activity</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Applications -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Applications</h5>
                    <a href="{{ route('admin.submissions') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant</th>
                                    <th>Aadhar</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentApplications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $application->name }}</h6>
                                            <small class="text-muted">{{ $application->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>{{ substr($application->aadhar_number, 0, 4) }}XXXX{{ substr($application->aadhar_number, -4) }}</td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($application->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($application->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($application->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.view-submission', $application->id) }}" class="btn btn-sm btn-primary me-2">View</a>
                                        @if($application->status == 'pending')
                                        <div class="btn-group">
                                            <a href="{{ route('admin.accept-form', $application->id) }}" class="btn btn-sm btn-success">Accept</a>
                                            <a href="{{ route('admin.show-reject-form', $application->id) }}" class="btn btn-sm btn-danger">Reject</a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No applications found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Applications Chart
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Accepted',
                    data: [65, 59, 80, 81, @json($acceptedSubmissions)],
                    backgroundColor: '#198754'
                }, {
                    label: 'Pending',
                    data: [28, 48, 40, 19, @json($pendingSubmissions)],
                    backgroundColor: '#ffc107'
                }, {
                    label: 'Rejected',
                    data: [10, 15, 20, 15, @json($rejectedSubmissions)],
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Map initialization
        if (document.getElementById('map')) {
            const map = L.map('map').setView([20.5937, 78.9629], 5); // India's coordinates
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Example district data - replace with real data from your database
            const districtData = [
                { name: 'Delhi', lat: 28.7041, lng: 77.1025, count: 125 },
                { name: 'Chennai', lat: 13.0827, lng: 80.2707, count: 187 },
                { name: 'Ahmedabad', lat: 23.0225, lng: 72.5714, count: 98 },
                { name: 'Patna', lat: 25.5941, lng: 85.1376, count: 220 },
                { name: 'Jaipur', lat: 26.9124, lng: 75.7873, count: 75 },
                { name: 'Amritsar', lat: 31.6340, lng: 74.8723, count: 52 },
                { name: 'Mumbai', lat: 19.0760, lng: 72.8777, count: 248 },
                { name: 'Guwahati', lat: 26.1445, lng: 91.7362, count: 63 },
                { name: 'Bangalore', lat: 12.9716, lng: 77.5946, count: 112 },
                { name: 'Kolkata', lat: 22.5726, lng: 88.3639, count: 96 }
            ];
            
            districtData.forEach(function(district) {
                const radius = Math.sqrt(district.count) * 1000;
                const circle = L.circle([district.lat, district.lng], {
                    radius: radius,
                    color: '#0d6efd',
                    fillColor: '#0d6efd',
                    fillOpacity: 0.5
                }).addTo(map);
                
                circle.bindPopup('<b>' + district.name + '</b><br>Applications: ' + district.count);
            });
        }
    });
</script>
@endsection 