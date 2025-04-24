<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rural Housing MIS') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />

    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-blue: #0a58ca;
            --light-blue: #e7f1ff;
            --white: #ffffff;
            --light-gray: #f8f9fa;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: var(--white);
        }
        
        .navbar-nav .nav-link {
            color: #333;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        .top-header {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 5px 0;
        }
        
        .marquee-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        
        .marquee {
            white-space: nowrap;
            animation: marquee 30s linear infinite;
            display: inline-block;
            padding-left: 100%;
        }
        
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        
        .status-accepted {
            background-color: #198754;
            color: #fff;
        }
        
        .status-rejected {
            background-color: #dc3545;
            color: #fff;
        }
        
        .card-dashboard {
            transition: transform 0.3s;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        
        #map {
            height: 400px;
            border-radius: 10px;
        }
        
        .footer {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }
        
        .scheme-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .news-card {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .news-item {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .news-date {
            font-size: 12px;
            color: #6c757d;
        }
        
        .dashboard-stats {
            background: linear-gradient(to right, var(--primary-color), var(--dark-blue));
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .navbar-brand img {
                height: 30px;
            }
            
            .card {
                margin-bottom: 15px;
            }
            
            #map {
                height: 300px;
            }
        }
    </style>
    
    @yield('additional_styles')
</head>
<body>
    <!-- Top header with government logo and marquee -->
    <div class="top-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Government of India" style="height: 25px;">
                    <span class="ms-2">Rural Development Housing Scheme</span>
                </div>
                <div>
                    <span>Last Updated: {{ now()->format('d M, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification bar / Marquee -->
    <div class="bg-light py-1">
        <div class="container">
            <div class="marquee-container">
                <div class="marquee">
                    <i class="fas fa-bullhorn me-2"></i> Important Notification: Applications for the new housing scheme are now open until May 30, 2025. | 
                    <i class="fas fa-info-circle me-2"></i> Aadhar Card is mandatory for all applicants. |
                    <i class="fas fa-calendar me-2"></i> Next camp for document verification: May 10, 2025 at District Collectorate. |
                    <i class="fas fa-rupee-sign me-2"></i> Financial assistance up to ₹1,20,000 available for eligible applicants.
                </div>
            </div>
        </div>
    </div>

    <div id="app">
        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Logo">
                    <span>{{ config('app.name', 'Rural Housing MIS') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about-us') ? 'active' : '' }}" href="{{ url('/about-us') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('schemes') ? 'active' : '' }}" href="{{ url('/schemes') }}">Schemes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}" href="{{ url('/contact-us') }}">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('track') ? 'active' : '' }}" href="{{ route('track.form') }}">
                                <i class="fas fa-search me-1"></i> Track Application
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="fas fa-home me-2"></i> My Dashboard
                                        </a>
                                    @endif
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
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

            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Rural Housing MIS</h5>
                        <p>A Management Information System for Rural Development Housing Scheme</p>
                        <div class="d-flex mt-3">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                            <li><a href="{{ url('/about-us') }}" class="text-white">About Us</a></li>
                            <li><a href="{{ url('/schemes') }}" class="text-white">Schemes</a></li>
                            <li><a href="{{ url('/contact-us') }}" class="text-white">Contact Us</a></li>
                            <li><a href="{{ route('track.form') }}" class="text-white">Track Application</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Contact Information</h5>
                        <address class="text-white">
                            <p><i class="fas fa-map-marker-alt me-2"></i> Ministry of Rural Development<br/>Krishi Bhavan, New Delhi - 110001</p>
                            <p><i class="fas fa-phone me-2"></i> +91 11 2338 3760</p>
                            <p><i class="fas fa-envelope me-2"></i> contact@ruralmis.gov.in</p>
                        </address>
                    </div>
                </div>
                <hr class="bg-light">
                <div class="text-center">
                    <p class="mb-0">© {{ date('Y') }} Rural Housing MIS. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @yield('scripts')
</body>
</html>
