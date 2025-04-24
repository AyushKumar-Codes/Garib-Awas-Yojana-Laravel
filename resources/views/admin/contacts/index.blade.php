@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Contact Submissions</h6>
                    @if(session('success'))
                    <div class="alert alert-success text-white">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name/Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subject</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Message</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $contact->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $contact->email }}</p>
                                                @if($contact->phone_number)
                                                <p class="text-xs text-secondary mb-0">{{ $contact->phone_number }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $contact->subject }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($contact->message, 50) }}</p>
                                        <button type="button" class="btn btn-link text-xs p-0" data-bs-toggle="modal" data-bs-target="#messageModal{{ $contact->id }}">
                                            View Full Message
                                        </button>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($contact->status === 'unread')
                                        <span class="badge badge-sm bg-gradient-warning">Unread</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-success">Read</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $contact->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-primary mb-0">View</a>
                                        
                                        @if($contact->status === 'unread')
                                        <form action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-info mb-0">Mark as Read</button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mb-0">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Message Modal -->
                                <div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel{{ $contact->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="messageModalLabel{{ $contact->id }}">Message from {{ $contact->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Subject:</strong> {{ $contact->subject }}</p>
                                                <p><strong>Email:</strong> {{ $contact->email }}</p>
                                                @if($contact->phone_number)
                                                <p><strong>Phone:</strong> {{ $contact->phone_number }}</p>
                                                @endif
                                                <p><strong>Message:</strong></p>
                                                <div class="p-3 bg-gray-100 rounded">
                                                    {{ $contact->message }}
                                                </div>
                                                <p class="mt-2 text-xs text-secondary">Received on {{ $contact->created_at->format('F d, Y \a\t h:i A') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="mailto:{{ $contact->email }}" class="btn btn-primary">Reply via Email</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No contact submissions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 