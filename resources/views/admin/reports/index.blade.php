@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Application Reports</h2>
            <p class="lead">Generate and download application statistics and data</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="mb-2">
                <small class="text-muted refresh-timestamp">Last refreshed: {{ $lastRefreshed->format('M d, Y, h:i:s A') }}</small>
            </div>
            <a href="{{ route('admin.reports') }}" class="btn btn-primary refresh-btn" data-api-url="{{ route('admin.reports.api.latest-data') }}">
                <i class="fas fa-sync-alt"></i> Refresh Data
            </a>
        </div>
    </div>
    
    <!-- Summary Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Housing Applications Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h3 class="text-primary" id="totalCount">{{ $totalCount }}</h3>
                            <p>Total Applications</p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-warning" id="pendingCount">{{ $pendingCount }}</h3>
                            <p>Pending</p>
                        </div>
                        <div class="col-md-2">
                            <h3 class="text-success" id="acceptedCount">{{ $acceptedCount }}</h3>
                            <p>Accepted</p>
                        </div>
                        <div class="col-md-2">
                            <h3 class="text-danger" id="rejectedCount">{{ $rejectedCount }}</h3>
                            <p>Rejected</p>
                        </div>
                        <div class="col-md-2">
                            <h3 class="text-info" id="totalUsers">{{ $totalUsers }}</h3>
                            <p>Registered Users</p>
                        </div>
                    </div>
                    <div class="progress mt-3">
                        @if($totalCount > 0)
                            <div class="progress-bar bg-warning" role="progressbar" 
                                 style="width: @php echo ($pendingCount / $totalCount) * 100 @endphp%" 
                                 aria-valuenow="{{ $pendingCount }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $totalCount }}"></div>
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: @php echo ($acceptedCount / $totalCount) * 100 @endphp%" 
                                 aria-valuenow="{{ $acceptedCount }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $totalCount }}"></div>
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: @php echo ($rejectedCount / $totalCount) * 100 @endphp%" 
                                 aria-valuenow="{{ $rejectedCount }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $totalCount }}"></div>
                        @else
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-2 small">
                        <span class="text-warning">{{ $pendingCount }} Pending</span>
                        <span class="text-success">{{ $acceptedCount }} Accepted</span>
                        <span class="text-danger">{{ $rejectedCount }} Rejected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Application Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5>Total Applications</h5>
                    <h2 class="display-4" id="statTotalCount">{{ $totalCount }}</h2>
                    <a href="{{ route('admin.reports.download.all') }}" class="btn btn-light btn-sm mt-2">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <h5>Pending</h5>
                    <h2 class="display-4" id="statPendingCount">{{ $pendingCount }}</h2>
                    <a href="{{ route('admin.reports.download.status', 'pending') }}" class="btn btn-dark btn-sm mt-2">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5>Accepted</h5>
                    <h2 class="display-4" id="statAcceptedCount">{{ $acceptedCount }}</h2>
                    <a href="{{ route('admin.reports.download.status', 'accepted') }}" class="btn btn-light btn-sm mt-2">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <h5>Rejected</h5>
                    <h2 class="display-4" id="statRejectedCount">{{ $rejectedCount }}</h2>
                    <a href="{{ route('admin.reports.download.status', 'rejected') }}" class="btn btn-light btn-sm mt-2">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Users Stats -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Total Registered Users</h5>
                        <h2 class="display-4">{{ $totalUsers }}</h2>
                    </div>
                    <div>
                        <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-users"></i> View All Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Latest Applications -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Recent Applications</h5>
                </div>
                <div class="card-body">
                    @if(count($latestSubmissions) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tracking ID</th>
                                        <th>Applicant</th>
                                        <th>Income</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->id }}</td>
                                        <td>{{ $submission->tracking_id }}</td>
                                        <td>
                                            <div>{{ $submission->name }}</div>
                                            <small class="text-muted">{{ $submission->user->email }}</small>
                                        </td>
                                        <td>₹{{ number_format($submission->annual_income, 2) }}</td>
                                        <td>
                                            @if($submission->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($submission->status == 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $submission->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.view-submission', $submission->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No applications found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Monthly Reports -->
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Monthly Reports ({{ date('Y') }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th class="text-center">Pending</th>
                                    <th class="text-center">Accepted</th>
                                    <th class="text-center">Rejected</th>
                                    <th class="text-center">Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyStats as $month => $stats)
                                <tr>
                                    <td>{{ $stats['month_name'] }}</td>
                                    <td class="text-center">{{ $stats['pending'] }}</td>
                                    <td class="text-center">{{ $stats['accepted'] }}</td>
                                    <td class="text-center">{{ $stats['rejected'] }}</td>
                                    <td class="text-center"><strong>{{ $stats['total'] }}</strong></td>
                                    <td>
                                        @if($stats['total'] > 0)
                                            <a href="{{ route('admin.reports.download.monthly', ['month' => $month, 'year' => date('Y')]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No data</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Top Users</h5>
                </div>
                <div class="card-body">
                    @if(count($topUsers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Applications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $user)
                                    <tr>
                                        <td>
                                            <div>{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-primary">{{ $user->form_submissions_count }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No user data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set up automatic refresh every 30 seconds
    setInterval(fetchLatestData, 30000);
    
    // Function to fetch the latest data via AJAX
    function fetchLatestData() {
        // Get API URL from the data attribute
        const apiUrl = document.querySelector('.refresh-btn').getAttribute('data-api-url');
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Update the last refreshed timestamp
                const refreshTimestamp = document.querySelector('.refresh-timestamp');
                if (refreshTimestamp) {
                    refreshTimestamp.textContent = 'Last auto-refreshed: ' + data.lastRefreshed;
                }
                
                // Update counts in the UI
                updateElementText('totalCount', data.totalCount);
                updateElementText('pendingCount', data.pendingCount);
                updateElementText('acceptedCount', data.acceptedCount);
                updateElementText('rejectedCount', data.rejectedCount);
                updateElementText('totalUsers', data.totalUsers);
                
                // Update stats cards
                updateElementText('statTotalCount', data.totalCount);
                updateElementText('statPendingCount', data.pendingCount);
                updateElementText('statAcceptedCount', data.acceptedCount);
                updateElementText('statRejectedCount', data.rejectedCount);
                
                // Update progress bar
                if (data.totalCount > 0) {
                    updateProgressBar(data.pendingCount, data.acceptedCount, data.rejectedCount, data.totalCount);
                }
                
                console.log('Data refreshed successfully at ' + data.lastRefreshed);
            })
            .catch(error => console.error('Error fetching latest data:', error));
    }
    
    // Helper function to update text content with animation
    function updateElementText(id, newValue) {
        const element = document.getElementById(id);
        if (element) {
            // Add a brief highlight effect
            element.classList.add('highlight-update');
            element.textContent = newValue;
            
            // Remove highlight effect after a short delay
            setTimeout(() => {
                element.classList.remove('highlight-update');
            }, 1000);
        }
    }
    
    // Helper function to update progress bar
    function updateProgressBar(pending, accepted, rejected, total) {
        const pendingBar = document.querySelector('.progress-bar.bg-warning');
        const acceptedBar = document.querySelector('.progress-bar.bg-success');
        const rejectedBar = document.querySelector('.progress-bar.bg-danger');
        
        if (pendingBar && acceptedBar && rejectedBar) {
            const pendingWidth = (pending / total) * 100;
            const acceptedWidth = (accepted / total) * 100;
            const rejectedWidth = (rejected / total) * 100;
            
            pendingBar.style.width = pendingWidth + '%';
            pendingBar.setAttribute('aria-valuenow', pending);
            
            acceptedBar.style.width = acceptedWidth + '%';
            acceptedBar.setAttribute('aria-valuenow', accepted);
            
            rejectedBar.style.width = rejectedWidth + '%';
            rejectedBar.setAttribute('aria-valuenow', rejected);
        }
    }
    
    // Setup manual refresh button click handler
    const refreshButton = document.querySelector('.refresh-btn');
    if (refreshButton) {
        refreshButton.addEventListener('click', function(e) {
            e.preventDefault();
            // Show loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
            this.disabled = true;
            
            // Fetch latest data
            fetchLatestData();
            
            // Reset button after a short delay
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-sync-alt"></i> Refresh Data';
                this.disabled = false;
            }, 1000);
        });
    }
});
</script>

<style>
/* Animation for data updates */
.highlight-update {
    animation: highlight-fade 1s ease-in-out;
}

@keyframes highlight-fade {
    0% { background-color: rgba(255, 255, 0, 0.5); }
    100% { background-color: transparent; }
}
</style>
@endsection 