@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Contacts
            </a>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Contact Details</h5>
                        <div>
                            @if($contact->status === 'unread')
                            <form action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-info mb-0">Mark as Read</button>
                            </form>
                            @else
                            <span class="badge bg-gradient-success">Read</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success text-white">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <h6 class="text-uppercase text-sm">Contact Information</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Name</label>
                                    <p class="form-control-static">{{ $contact->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <p class="form-control-static">
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Phone Number</label>
                                    <p class="form-control-static">
                                        @if($contact->phone_number)
                                        <a href="tel:{{ $contact->phone_number }}">{{ $contact->phone_number }}</a>
                                        @else
                                        <span class="text-muted">Not provided</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Date Submitted</label>
                                    <p class="form-control-static">
                                        {{ $contact->created_at->format('F d, Y \a\t h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="horizontal dark">
                    
                    <div class="mb-4">
                        <h6 class="text-uppercase text-sm">Message</h6>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Subject</label>
                                    <p class="form-control-static font-weight-bold">{{ $contact->subject }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Message</label>
                                    <div class="p-3 bg-gray-100 rounded">
                                        {{ $contact->message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="horizontal dark">
                    
                    <div class="d-flex justify-content-between">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i> Reply via Email
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 