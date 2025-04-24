@extends('layouts.app')

@section('additional_styles')
<style>
    .scheme-header {
        background: linear-gradient(to right, var(--primary-color), var(--dark-blue));
        color: white;
        border-radius: 10px;
        padding: 40px 30px;
        margin-bottom: 40px;
    }
    
    .scheme-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
        margin-bottom: 30px;
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
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 1.5rem;
    }
    
    .icon-primary {
        background-color: var(--light-blue);
        color: var(--primary-color);
    }
    
    .icon-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .icon-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .faq-item {
        margin-bottom: 20px;
    }
    
    .faq-question {
        cursor: pointer;
        font-weight: 600;
        color: var(--dark-blue);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: var(--light-blue);
        border-radius: 10px;
    }
    
    .faq-answer {
        padding: 15px;
        border-radius: 0 0 10px 10px;
        background-color: #f8f9fa;
        display: none;
    }
    
    .faq-question.active {
        border-radius: 10px 10px 0 0;
    }
    
    .faq-question.active + .faq-answer {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Schemes Header -->
    <div class="scheme-header text-center">
        <h1>Rural Housing Schemes</h1>
        <p class="lead">Explore government housing schemes designed to provide affordable housing solutions for rural communities</p>
    </div>
    
    <!-- Current Schemes Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Current Housing Schemes</h2>
            <p class="lead">Government schemes currently open for applications</p>
        </div>
        
        <div class="col-md-4">
            <div class="card scheme-card">
                <span class="badge bg-success scheme-badge">Popular</span>
                <img src="https://pmayg.nic.in/netiay/Images/sliderone.jpg" class="scheme-img" alt="Housing Scheme 1">
                <div class="card-body">
                    <h4 class="card-title">Pradhan Mantri Awaas Yojana - Gramin</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Launched: 2015</h6>
                    <p class="card-text">A flagship program providing assistance for construction of houses to eligible homeless families and those living in dilapidated houses in rural areas.</p>
                    
                    <h6 class="mt-3">Key Features:</h6>
                    <ul>
                        <li>Financial assistance of ₹1,20,000 in plain areas</li>
                        <li>Financial assistance of ₹1,30,000 in hilly/difficult areas</li>
                        <li>90 days of unskilled labor wages under MGNREGA</li>
                        <li>Interest subsidy of 3% on loans up to ₹2,00,000</li>
                    </ul>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="text-success"><strong>₹1,20,000</strong> assistance</span>
                        <a href="{{ route('form') }}" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card scheme-card">
                <img src="https://pmayg.nic.in/netiay/Images/slidertwo.jpg" class="scheme-img" alt="Housing Scheme 2">
                <div class="card-body">
                    <h4 class="card-title">Credit Linked Subsidy Scheme</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Launched: 2017</h6>
                    <p class="card-text">Provides interest subsidy on home loans taken by eligible applicants for acquisition or construction of houses.</p>
                    
                    <h6 class="mt-3">Key Features:</h6>
                    <ul>
                        <li>Interest subsidy at 6.5% for EWS and LIG categories</li>
                        <li>Interest subsidy at 4% for MIG-I category</li>
                        <li>Interest subsidy at 3% for MIG-II category</li>
                        <li>Loan amount up to ₹6,00,000 for EWS/LIG</li>
                    </ul>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="text-success"><strong>6.5%</strong> interest subsidy</span>
                        <a href="{{ route('form') }}" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card scheme-card">
                <span class="badge bg-primary scheme-badge">New</span>
                <img src="https://pmayg.nic.in/netiay/Images/sliderthree.jpg" class="scheme-img" alt="Housing Scheme 3">
                <div class="card-body">
                    <h4 class="card-title">Rural Housing Interest Subsidy Scheme</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Launched: 2023</h6>
                    <p class="card-text">Subsidizing interest for rural housing to make it more affordable for people in rural areas.</p>
                    
                    <h6 class="mt-3">Key Features:</h6>
                    <ul>
                        <li>Subsidy of ₹75,000 for construction or enhancement</li>
                        <li>Interest subsidy on loans up to ₹3,00,000</li>
                        <li>Priority to landless laborers and marginalized sections</li>
                        <li>Additional support for toilet construction</li>
                    </ul>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="text-success"><strong>₹75,000</strong> subsidy</span>
                        <a href="{{ route('form') }}" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Benefits Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Benefits of Housing Schemes</h2>
            <p class="lead">How these schemes are transforming rural communities</p>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon icon-primary mx-auto">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4>Secure Shelter</h4>
                    <p>Providing durable, all-weather houses with basic amenities to ensure safety and security for rural families.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon icon-success mx-auto">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h4>Financial Support</h4>
                    <p>Financial assistance and interest subsidies make housing affordable for economically weaker sections.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon icon-warning mx-auto">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Improved Quality of Life</h4>
                    <p>Better housing leads to improved health, education outcomes, and overall well-being for rural communities.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Eligibility Section -->
    <div class="row mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2>Eligibility Criteria</h2>
            <p>To be eligible for the Rural Housing Schemes, applicants must meet the following criteria:</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Must be a resident of a rural area</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Must be houseless or living in dilapidated house</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Must not have availed any housing benefit earlier</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Must not own a pucca house (permanent house) in their name</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Must belong to below poverty line (BPL) category</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Priority given to SC/ST, minorities, and disabled persons</li>
            </ul>
        </div>
        
        <div class="col-md-6">
            <h2>Required Documents</h2>
            <p>The following documents are required when applying for housing schemes:</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> Aadhar Card (mandatory)</li>
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> Income Certificate</li>
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> Land Ownership Documents (if available)</li>
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> BPL Card or Certificate</li>
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> Passport size photographs</li>
                <li class="list-group-item"><i class="fas fa-file-alt text-primary me-2"></i> Bank Account Details for Direct Benefit Transfer</li>
            </ul>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">Frequently Asked Questions</h2>
            <p class="lead text-center">Common questions about housing schemes</p>
        </div>
        
        <div class="col-md-12">
            <div class="faq-item">
                <div class="faq-question">
                    <span>How much financial assistance is provided under PMAY-G?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Under PMAY-G, a financial assistance of ₹1.20 lakh in plain areas and ₹1.30 lakh in hilly states, difficult areas and IAP districts is provided to the beneficiary for construction of the house.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Who is eligible for these housing schemes?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Eligibility varies slightly between schemes, but generally includes people who are houseless or living in dilapidated houses, are below the poverty line, and have not received any housing benefits from the government before. Priority is given to marginalized groups including SC/ST households, minorities, and persons with disabilities.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How can I apply for these housing schemes?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>You can apply online through this portal by registering and filling out the application form. Alternatively, you can also visit your nearest Gram Panchayat office for assistance with the application process.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What documents are required for application?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Required documents include your Aadhar Card, income certificate, land ownership documents (if available), BPL card or certificate, passport-sized photographs, and bank account details for direct benefit transfer.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How long does it take to get approval?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>After submission, applications typically undergo verification at multiple levels, which can take 2-3 months. Once approved, the funds are released in installments based on the construction progress of your house.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call-to-Action -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-3">Ready to Apply for Housing Assistance?</h2>
                    <p class="lead mb-4">Join millions of beneficiaries across India and apply for the rural housing scheme today.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('form') }}" class="btn btn-light btn-lg">Apply Now</a>
                        <a href="{{ url('/contact-us') }}" class="btn btn-outline-light btn-lg">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Toggle
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                this.classList.toggle('active');
                
                const icon = this.querySelector('i');
                if (this.classList.contains('active')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
    });
</script>
@endsection 