@extends('layouts.app')

@section('additional_styles')
<style>
    .contact-header {
        background: linear-gradient(to right, var(--primary-color), var(--dark-blue));
        color: white;
        border-radius: 10px;
        padding: 40px 30px;
        margin-bottom: 40px;
    }
    
    .contact-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
        margin-bottom: 30px;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
    }
    
    .contact-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 2rem;
        background-color: var(--light-blue);
        color: var(--primary-color);
    }
    
    .office-details {
        background-color: var(--light-blue);
        border-radius: 10px;
        padding: 20px;
    }
    
    .map-container {
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Contact Header -->
    <div class="contact-header text-center">
        <h1>Contact Us</h1>
        <p class="lead">We're here to help with your housing needs and inquiries</p>
    </div>
    
    <!-- Contact Information -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="contact-card">
                <div class="card-body text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Visit Us</h4>
                    <p>Ministry of Rural Development<br>Krishi Bhavan, New Delhi - 110001</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="contact-card">
                <div class="card-body text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p>Toll Free: 1800-123-4567<br>Office: +91 11 2338 3760</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="contact-card">
                <div class="card-body text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email Us</h4>
                    <p>General Inquiries: contact@ruralmis.gov.in<br>Support: support@ruralmis.gov.in</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Form & Office Details -->
    <div class="row mb-5">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <h2 class="mb-4">Send Us a Message</h2>
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required value="{{ old('email') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="Enter your phone number" value="{{ old('phone_number') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="" selected disabled>Select a subject</option>
                                <option value="Application Inquiry" {{ old('subject') == 'Application Inquiry' ? 'selected' : '' }}>Application Inquiry</option>
                                <option value="Scheme Information" {{ old('subject') == 'Scheme Information' ? 'selected' : '' }}>Scheme Information</option>
                                <option value="Status Update" {{ old('subject') == 'Status Update' ? 'selected' : '' }}>Status Update</option>
                                <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                                <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <h2 class="mb-4">Our Offices</h2>
            
            <div class="office-details mb-4">
                <h5><i class="fas fa-building me-2"></i> Head Office - New Delhi</h5>
                <hr>
                <p><strong>Address:</strong> Ministry of Rural Development, Krishi Bhavan, New Delhi - 110001</p>
                <p><strong>Phone:</strong> +91 11 2338 3760</p>
                <p><strong>Email:</strong> contact@ruralmis.gov.in</p>
                <p><strong>Working Hours:</strong> Monday - Friday: 9:00 AM - 5:30 PM</p>
            </div>
            
            <div class="office-details">
                <h5><i class="fas fa-building me-2"></i> Regional Office - Mumbai</h5>
                <hr>
                <p><strong>Address:</strong> Rural Housing Division, 5th Floor, CGO Complex, Mumbai - 400021</p>
                <p><strong>Phone:</strong> +91 22 2284 3760</p>
                <p><strong>Email:</strong> mumbai@ruralmis.gov.in</p>
                <p><strong>Working Hours:</strong> Monday - Friday: 9:00 AM - 5:30 PM</p>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">Find Us</h2>
        </div>
        <div class="col-12">
            <div class="map-container" id="map"></div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">Frequently Asked Questions</h2>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5><i class="fas fa-question-circle text-primary me-2"></i> How can I check my application status?</h5>
                    <p>You can check your application status by logging into your account on our portal and visiting the "My Applications" section where all your submitted applications and their current status will be displayed.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5><i class="fas fa-question-circle text-primary me-2"></i> What should I do if I face technical issues?</h5>
                    <p>For technical issues, you can contact our technical support team at support@ruralmis.gov.in or call our toll-free helpline at 1800-123-4567. Our support team is available Monday to Friday from 9:00 AM to 5:30 PM.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5><i class="fas fa-question-circle text-primary me-2"></i> How long does it take to process my application?</h5>
                    <p>Application processing typically takes 2-3 months, which includes verification, documentation checks, and approval processes. You will be notified via email and SMS about significant status changes.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5><i class="fas fa-question-circle text-primary me-2"></i> Can I visit your office for assistance?</h5>
                    <p>Yes, you can visit our head office in New Delhi or any of our regional offices during working hours (Monday - Friday: 9:00 AM - 5:30 PM). It's recommended to book an appointment in advance for better assistance.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Social Media Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="mb-4">Connect With Us</h2>
            <div class="d-flex justify-content-center gap-4">
                <a href="#" class="btn btn-outline-primary btn-lg rounded-circle">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn btn-outline-info btn-lg rounded-circle">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-lg rounded-circle">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-lg rounded-circle">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="btn btn-outline-success btn-lg rounded-circle">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map for office location
        if (document.getElementById('map')) {
            const map = L.map('map').setView([28.6139, 77.2090], 12); // New Delhi coordinates
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add marker for office location
            const marker = L.marker([28.6139, 77.2090]).addTo(map);
            marker.bindPopup("<b>Ministry of Rural Development</b><br>Krishi Bhavan, New Delhi - 110001").openPopup();
        }
    });
</script>
@endsection 