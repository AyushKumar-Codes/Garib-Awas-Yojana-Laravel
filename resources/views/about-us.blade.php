@extends('layouts.app')

@section('additional_styles')
<style>
    .about-header {
        background: linear-gradient(to right, var(--primary-color), var(--dark-blue));
        color: white;
        border-radius: 10px;
        padding: 40px 30px;
        margin-bottom: 40px;
    }
    
    .about-img {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .about-img img {
        width: 100%;
        transition: transform 0.5s;
    }
    
    .about-img:hover img {
        transform: scale(1.05);
    }
    
    .vision-mission-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
        margin-bottom: 20px;
    }
    
    .vision-mission-card:hover {
        transform: translateY(-5px);
    }
    
    .icon-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 2rem;
    }
    
    .icon-primary {
        background-color: var(--light-blue);
        color: var(--primary-color);
    }
    
    .icon-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: var(--light-blue);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
    }
    
    .timeline-container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }
    
    .timeline-container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -13px;
        background-color: white;
        border: 4px solid var(--primary-color);
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }
    
    .timeline-left {
        left: 0;
    }
    
    .timeline-right {
        left: 50%;
    }
    
    .timeline-left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid #f8f9fa;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #f8f9fa;
    }
    
    .timeline-right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid #f8f9fa;
        border-width: 10px 10px 10px 0;
        border-color: transparent #f8f9fa transparent transparent;
    }
    
    .timeline-right::after {
        left: -12px;
    }
    
    .timeline-content {
        padding: 20px 30px;
        background-color: #f8f9fa;
        position: relative;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .team-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }
    
    .social-links {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }
    
    .social-links a {
        margin: 0 5px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: var(--light-blue);
        color: var(--primary-color);
        transition: all 0.3s;
    }
    
    .social-links a:hover {
        background-color: var(--primary-color);
        color: white;
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
    
    @media screen and (max-width: 600px) {
        .timeline::after {
            left: 31px;
        }
        
        .timeline-container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }
        
        .timeline-container::before {
            left: 60px;
            border: medium solid #f8f9fa;
            border-width: 10px 10px 10px 0;
            border-color: transparent #f8f9fa transparent transparent;
        }
        
        .timeline-left::after, .timeline-right::after {
            left: 18px;
        }
        
        .timeline-right {
            left: 0%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- About Header -->
    <div class="about-header text-center">
        <h1>About Us</h1>
        <p class="lead">Learn more about the Rural Housing MIS and our mission to provide affordable housing for all</p>
    </div>
    
    <!-- About Section -->
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2>Rural Housing Management Information System</h2>
            <p>The Rural Housing Management Information System (MIS) is an initiative by the Ministry of Rural Development, Government of India, aimed at streamlining the implementation of various rural housing schemes across the country.</p>
            <p>Our platform serves as an integrated digital solution for managing applications, tracking progress, ensuring transparency, and facilitating the efficient delivery of housing benefits to eligible rural families.</p>
            <p>Through this system, we aim to bridge the housing gap in rural India by providing a user-friendly interface for beneficiaries to apply for housing assistance, track their applications, and receive timely updates on their status.</p>
            <div class="mt-4">
                <a href="{{ url('/schemes') }}" class="btn btn-primary me-3">Explore Schemes</a>
                <a href="{{ url('/contact-us') }}" class="btn btn-outline-primary">Contact Us</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="about-img">
                <img src="https://pmayg.nic.in/netiay/Images/sliderone.jpg" alt="Rural Housing" class="img-fluid">
            </div>
        </div>
    </div>
    
    <!-- Vision & Mission -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Our Vision & Mission</h2>
            <p class="lead">Working towards a better future for rural India</p>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="vision-mission-card">
                <div class="card-body text-center">
                    <div class="icon-box icon-primary mx-auto">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To ensure that every rural family has access to a safe, durable, and dignified home with basic amenities by 2025, contributing to inclusive rural development and improved quality of life.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="vision-mission-card">
                <div class="card-body text-center">
                    <div class="icon-box icon-success mx-auto">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To implement housing schemes efficiently through digital solutions, ensuring transparency, accountability, and timely delivery of benefits to eligible rural families, particularly those belonging to marginalized sections.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Key Stats -->
    <div class="row text-center mb-5 bg-light py-4 rounded">
        <div class="col-12 mb-4">
            <h2 class="section-title">Our Impact</h2>
            <p class="lead">Making a difference in rural housing development across India</p>
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
    
    <!-- Our History Timeline -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Our Journey</h2>
            <p class="lead">The evolution of rural housing initiatives in India</p>
        </div>
        
        <div class="col-12">
            <div class="timeline">
                <div class="timeline-container timeline-left">
                    <div class="timeline-content">
                        <h4>1985</h4>
                        <p>Launch of Indira Awaas Yojana (IAY), the first major rural housing scheme, targeting below poverty line families.</p>
                    </div>
                </div>
                <div class="timeline-container timeline-right">
                    <div class="timeline-content">
                        <h4>1996</h4>
                        <p>Expansion of IAY to include non-scheduled castes/scheduled tribes below poverty line rural households.</p>
                    </div>
                </div>
                <div class="timeline-container timeline-left">
                    <div class="timeline-content">
                        <h4>2005</h4>
                        <p>Introduction of homestead schemes to provide land to landless poor for house construction.</p>
                    </div>
                </div>
                <div class="timeline-container timeline-right">
                    <div class="timeline-content">
                        <h4>2015</h4>
                        <p>Launch of Pradhan Mantri Awaas Yojana - Gramin (PMAY-G) to replace IAY with enhanced features and benefits.</p>
                    </div>
                </div>
                <div class="timeline-container timeline-left">
                    <div class="timeline-content">
                        <h4>2018</h4>
                        <p>Implementation of Rural Housing MIS to digitize the application process and enhance transparency.</p>
                    </div>
                </div>
                <div class="timeline-container timeline-right">
                    <div class="timeline-content">
                        <h4>2023</h4>
                        <p>Introduction of additional schemes and enhancement of existing programs with focus on sustainable housing solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Team -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Leadership Team</h2>
            <p class="lead">Meet the people behind the Rural Housing initiative</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="team-card">
                <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Team Member" class="team-img">
                <div class="card-body text-center">
                    <h4>Rajesh Kumar Singh</h4>
                    <p class="text-muted">Secretary, Ministry of Rural Development</p>
                    <p>Over 25 years of experience in rural development and housing policy implementation.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="team-card">
                <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Team Member" class="team-img">
                <div class="card-body text-center">
                    <h4>Dr. Ananya Sharma</h4>
                    <p class="text-muted">Joint Secretary, Rural Housing Division</p>
                    <p>Specialist in sustainable rural development with focus on affordable housing solutions.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="team-card">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team Member" class="team-img">
                <div class="card-body text-center">
                    <h4>Vikram Patel</h4>
                    <p class="text-muted">Director, PMAY-G Implementation</p>
                    <p>Expert in program implementation and monitoring with extensive field experience.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Principles -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Our Core Principles</h2>
            <p class="lead">Values that guide our housing initiatives</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4><i class="fas fa-hand-holding-heart text-primary me-2"></i> Inclusive Development</h4>
                    <p>We are committed to reaching the most marginalized sections of rural society, ensuring that no eligible family is left behind in our housing initiatives.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4><i class="fas fa-shield-alt text-primary me-2"></i> Transparency</h4>
                    <p>We maintain complete transparency in our operations, from selection of beneficiaries to fund allocation, ensuring accountability at all levels.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4><i class="fas fa-leaf text-primary me-2"></i> Sustainability</h4>
                    <p>We promote the use of locally available materials and eco-friendly technologies to ensure sustainable housing solutions that are in harmony with the environment.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4><i class="fas fa-users text-primary me-2"></i> Community Participation</h4>
                    <p>We believe in involving local communities in the planning and implementation process, fostering a sense of ownership and ensuring that housing solutions meet local needs and preferences.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4><i class="fas fa-rocket text-primary me-2"></i> Innovation</h4>
                    <p>We continuously strive to incorporate innovative technologies and approaches to improve the quality, affordability, and delivery of rural housing, adapting to changing needs and challenges.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Partners Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Our Partners</h2>
            <p class="lead">Collaborating for better rural housing</p>
        </div>
        
        <div class="col-md-3 col-6 text-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Partner Logo" class="img-fluid" style="height: 100px;">
            <p class="mt-2">Ministry of Finance</p>
        </div>
        
        <div class="col-md-3 col-6 text-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Partner Logo" class="img-fluid" style="height: 100px;">
            <p class="mt-2">NABARD</p>
        </div>
        
        <div class="col-md-3 col-6 text-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Partner Logo" class="img-fluid" style="height: 100px;">
            <p class="mt-2">State Rural Development Depts.</p>
        </div>
        
        <div class="col-md-3 col-6 text-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/240px-Emblem_of_India.svg.png" alt="Partner Logo" class="img-fluid" style="height: 100px;">
            <p class="mt-2">UN-Habitat</p>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-3">Ready to Apply for Housing Assistance?</h2>
                    <p class="lead mb-4">Join millions of beneficiaries across India and apply for rural housing schemes today.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Register Now</a>
                        <a href="{{ url('/schemes') }}" class="btn btn-outline-light btn-lg">Explore Schemes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 