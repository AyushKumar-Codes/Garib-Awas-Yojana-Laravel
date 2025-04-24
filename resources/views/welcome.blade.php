@extends('layouts.app')

@section('additional_styles')
<style>
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 10px;
        padding: 20px;
    }
    
    .mission-vision-card {
        transition: all 0.3s;
        height: 100%;
    }
    
    .mission-vision-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .icon-rounded {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--light-blue);
        color: var(--primary-color);
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .counter-box {
        text-align: center;
        padding: 20px 0;
    }
    
    .counter-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .counter-text {
        font-weight: 600;
        color: #555;
    }
    
    .scheme-box {
        background-color: var(--light-blue);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    
    .scheme-box:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .scheme-box:hover .btn-outline-primary {
        color: var(--primary-color);
        background-color: white;
    }
    
    .testimonial-card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .testimonial-content {
        padding: 20px;
        background-color: var(--light-gray);
    }
    
    .testimonial-user {
        padding: 15px 20px;
        background-color: var(--primary-color);
        color: white;
    }
    
    .testimonial-user img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }
    
    .news-ticker {
        height: 350px;
        overflow: hidden;
        position: relative;
    }
    
    .news-ticker-items {
        position: absolute;
        top: 0;
        animation: scroll-news 25s linear infinite;
    }
    
    @keyframes scroll-news {
        0% { top: 350px; }
        100% { top: -350px; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://pmayg.nic.in/netiay/Images/sliderone.jpg" class="d-block w-100" alt="Rural Housing 1">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Rural Housing Scheme</h2>
                    <p>Providing affordable housing solutions for rural India</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://pmayg.nic.in/netiay/Images/slidertwo.jpg" class="d-block w-100" alt="Rural Housing 2">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Financial Assistance</h2>
                    <p>Get up to ₹1,20,000 for building your dream home</p>
                    <a href="{{ url('/schemes') }}" class="btn btn-primary">View Schemes</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://pmayg.nic.in/netiay/Images/sliderthree.jpg" class="d-block w-100" alt="Rural Housing 3">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Easy Application Process</h2>
                    <p>Simple online application with minimal documentation</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Apply Online</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-5">
    <!-- Key Stats Section -->
    <div class="row text-center mb-5">
        <div class="col-12 mb-4">
            <h2 class="section-title">Making a Difference</h2>
            <p class="lead">Our impact in rural housing development across India</p>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
            <div class="counter-box">
                <div class="counter-number">2.5M+</div>
                <div class="counter-text">Houses Built</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
            <div class="counter-box">
                <div class="counter-number">600+</div>
                <div class="counter-text">Districts Covered</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="counter-box">
                <div class="counter-number">₹30K Cr</div>
                <div class="counter-text">Funds Allocated</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="counter-box">
                <div class="counter-number">10M+</div>
                <div class="counter-text">Lives Changed</div>
            </div>
        </div>
    </div>
    
    <!-- Mission & Vision Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Our Mission & Vision</h2>
            <p class="lead">Committed to providing housing for every rural family</p>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card mission-vision-card">
                <div class="card-body text-center">
                    <div class="icon-rounded">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To provide affordable housing to all rural families by 2025, ensuring that every Indian has access to a dignified living space with basic amenities.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card mission-vision-card">
                <div class="card-body text-center">
                    <div class="icon-rounded">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>Creating inclusive rural communities with sustainable housing, fostering economic growth and improving the quality of life for millions of rural families.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card mission-vision-card">
                <div class="card-body text-center">
                    <div class="icon-rounded">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Goal</h3>
                    <p>To achieve 'Housing for All' by implementing innovative construction technologies, providing financial assistance, and ensuring transparent processes.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Schemes & News Section -->
    <div class="row mb-5">
        <div class="col-md-8 mb-4 mb-md-0">
            <h2 class="section-title mb-4">Housing Schemes</h2>
            <div class="scheme-box">
                <h4>Pradhan Mantri Awaas Yojana - Gramin (PMAY-G)</h4>
                <p>A flagship program providing assistance for construction of houses to eligible homeless families and those living in dilapidated houses in rural areas.</p>
                <a href="{{ url('/schemes') }}" class="btn btn-outline-primary">Learn More</a>
            </div>
            <div class="scheme-box">
                <h4>Credit Linked Subsidy Scheme (CLSS)</h4>
                <p>Provides interest subsidy on home loans taken by eligible urban poor for acquisition or construction of houses.</p>
                <a href="{{ url('/schemes') }}" class="btn btn-outline-primary">Learn More</a>
            </div>
            <div class="scheme-box">
                <h4>Rural Housing Interest Subsidy Scheme</h4>
                <p>Provides interest subsidy for rural housing to make it more affordable for people living in rural areas.</p>
                <a href="{{ url('/schemes') }}" class="btn btn-outline-primary">Learn More</a>
            </div>
        </div>
        <div class="col-md-4">
            <h2 class="section-title mb-4">Latest Updates</h2>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">News & Announcements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="news-ticker">
                        <div class="news-ticker-items">
                            <div class="news-item">
                                <span class="news-date">May 1, 2025</span>
                                <h6>New Phase of PMAY-G Launched</h6>
                                <p>The government has announced the next phase of PMAY-G targeting 1 million new houses.</p>
                            </div>
                            <div class="news-item">
                                <span class="news-date">April 25, 2025</span>
                                <h6>Loan Interest Rates Reduced</h6>
                                <p>Interest rates for rural housing loans reduced by 1.5% to support more beneficiaries.</p>
                            </div>
                            <div class="news-item">
                                <span class="news-date">April 18, 2025</span>
                                <h6>New Documentation Guidelines</h6>
                                <p>Simplified documentation process announced to make applications easier for rural residents.</p>
                            </div>
                            <div class="news-item">
                                <span class="news-date">April 10, 2025</span>
                                <h6>Mobile App for Applicants Launched</h6>
                                <p>New mobile application launched to track application status and receive updates.</p>
                            </div>
                            <div class="news-item">
                                <span class="news-date">April 5, 2025</span>
                                <h6>Rural Housing Awards Announced</h6>
                                <p>Annual awards for best implementation of housing schemes announced.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- GIS Map Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Scheme Implementation Map</h2>
            <p class="lead">Geographic distribution of housing project implementations across India</p>
        </div>
        <div class="col-12">
            <div id="map" style="height: 400px; border-radius: 10px;"></div>
        </div>
    </div>
    
    <!-- Testimonials Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Success Stories</h2>
            <p class="lead">Hear from our beneficiaries across rural India</p>
        </div>
        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <i class="fas fa-quote-left text-primary mb-3"></i>
                    <p>"Thanks to this scheme, my family finally has a proper roof over our heads. The application process was simpler than I expected."</p>
                </div>
                <div class="testimonial-user d-flex align-items-center">
                    <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Testimonial User">
                    <div class="ms-3">
                        <h6 class="mb-0">Ramesh Kumar</h6>
                        <small>Bihar</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <i class="fas fa-quote-left text-primary mb-3"></i>
                    <p>"The financial assistance helped us build a sturdy home that can withstand monsoons. Our children now have a safe place to study."</p>
                </div>
                <div class="testimonial-user d-flex align-items-center">
                    <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Testimonial User">
                    <div class="ms-3">
                        <h6 class="mb-0">Lakshmi Devi</h6>
                        <small>Tamil Nadu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <i class="fas fa-quote-left text-primary mb-3"></i>
                    <p>"After struggling for years in a thatched hut, we now have a concrete house with proper facilities. This scheme changed our lives."</p>
                </div>
                <div class="testimonial-user d-flex align-items-center">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial User">
                    <div class="ms-3">
                        <h6 class="mb-0">Mohan Singh</h6>
                        <small>Rajasthan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call-to-Action Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-3">Ready to Apply for Housing Assistance?</h2>
                    <p class="lead mb-4">Join millions of beneficiaries across India and apply for the rural housing scheme today.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Register Now</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize Leaflet Map for GIS representation
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([20.5937, 78.9629], 5); // India's coordinates
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add markers for implemented projects (example data)
        const implementationData = [
            { name: "Delhi Housing Project", lat: 28.7041, lng: 77.1025, houses: 12500 },
            { name: "Tamil Nadu Rural Housing", lat: 13.0827, lng: 80.2707, houses: 18700 },
            { name: "Gujarat Model Village", lat: 23.0225, lng: 72.5714, houses: 9800 },
            { name: "Bihar Development Project", lat: 25.5941, lng: 85.1376, houses: 22000 },
            { name: "Rajasthan Desert Housing", lat: 26.9124, lng: 75.7873, houses: 7500 },
            { name: "Punjab Border Development", lat: 31.6340, lng: 74.8723, houses: 5200 },
            { name: "Maharashtra Rural Initiative", lat: 19.7515, lng: 75.7139, houses: 14800 },
            { name: "Assam Flood Resistant Housing", lat: 26.2006, lng: 92.9376, houses: 6300 },
            { name: "Karnataka Housing Project", lat: 12.9716, lng: 77.5946, houses: 11200 },
            { name: "West Bengal Delta Region", lat: 22.5726, lng: 88.3639, houses: 9600 }
        ];
        
        implementationData.forEach(project => {
            const marker = L.marker([project.lat, project.lng]).addTo(map);
            marker.bindPopup(`<b>${project.name}</b><br>Houses built: ${project.houses}`);
        });
    });
</script>
@endsection
