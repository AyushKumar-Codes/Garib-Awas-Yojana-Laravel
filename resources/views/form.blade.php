@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Housing Scheme Application</h2>
            <p class="lead">Fill out the form below to apply for the Rural Development Housing Scheme</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Application Form</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('submit-form') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Complete Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="aadhar_number" class="form-label">Aadhar Number</label>
                            <input type="text" class="form-control @error('aadhar_number') is-invalid @enderror" 
                                id="aadhar_number" name="aadhar_number" value="{{ old('aadhar_number') }}" 
                                placeholder="12-digit Aadhar Number" maxlength="12" required>
                            @error('aadhar_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please enter your 12-digit Aadhar number without spaces</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="annual_income" class="form-label">Annual Income (₹)</label>
                            <input type="number" class="form-control @error('annual_income') is-invalid @enderror" 
                                id="annual_income" name="annual_income" value="{{ old('annual_income') }}" 
                                step="0.01" min="0" required>
                            @error('annual_income')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="document_type" class="form-label">Document Type for Address Proof <span class="text-danger">*</span></label>
                            <select class="form-select @error('document_type') is-invalid @enderror" 
                                id="document_type" name="document_type" required>
                                <option value="" selected disabled>Select a document type</option>
                                <option value="aadhar_card" {{ old('document_type') == 'aadhar_card' ? 'selected' : '' }}>Aadhar Card</option>
                                <option value="pan_card" {{ old('document_type') == 'pan_card' ? 'selected' : '' }}>PAN Card</option>
                                <option value="driving_license" {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                                <option value="income_certificate" {{ old('document_type') == 'income_certificate' ? 'selected' : '' }}>Income Certificate</option>
                            </select>
                            @error('document_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="document" class="form-label">Upload Document (PDF only) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('document') is-invalid @enderror" 
                                id="document" name="document" accept="application/pdf" required>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please upload a clear scan or photo of your document in PDF format (Max size: 2MB)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Why do you need housing assistance? (Optional)</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                id="message" name="message" rows="4">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Note:</strong> By submitting this form, you certify that all the information provided is true and correct to the best of your knowledge.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 