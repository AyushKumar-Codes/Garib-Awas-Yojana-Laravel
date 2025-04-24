<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Models\User;
use App\Models\Contact;
use App\Mail\FormAccepted;
use App\Mail\FormRejected;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalSubmissions = FormSubmission::count();
        $pendingSubmissions = FormSubmission::where('status', 'pending')->count();
        $acceptedSubmissions = FormSubmission::where('status', 'accepted')->count();
        $rejectedSubmissions = FormSubmission::where('status', 'rejected')->count();
        $totalUsers = User::where('role', 'user')->count();
        $unreadContacts = Contact::where('status', 'unread')->count();
        
        // Get recent applications for dashboard
        $recentApplications = FormSubmission::with('user')
            ->latest()
            ->take(4)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalSubmissions', 
            'pendingSubmissions', 
            'acceptedSubmissions', 
            'rejectedSubmissions', 
            'totalUsers',
            'unreadContacts',
            'recentApplications'
        ));
    }

    /**
     * Show all form submissions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showSubmissions()
    {
        $submissions = FormSubmission::with('user')->latest()->get();
        return view('admin.submissions', compact('submissions'));
    }

    /**
     * Show all users with their submissions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showUsers()
    {
        $users = User::where('role', 'user')->with('formSubmissions')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Accept a form submission.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptForm($id)
    {
        $submission = FormSubmission::findOrFail($id);
        $submission->status = 'accepted';
        $submission->rejection_reason = null; // Clear any previous rejection reason
        $submission->save();
        
        // Get the user associated with this submission
        $user = User::findOrFail($submission->user_id);
        
        // Send acceptance email
        Mail::to($user->email)->send(new FormAccepted($submission));
        
        return redirect()->back()->with('success', 'Form has been accepted successfully and notification email has been sent to the applicant.');
    }

    /**
     * Show form to enter reason for rejection.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showRejectForm($id)
    {
        $submission = FormSubmission::findOrFail($id);
        return view('admin.reject-form', compact('submission'));
    }

    /**
     * Reject a form submission.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectForm(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $submission = FormSubmission::findOrFail($id);
        
        // Delete the document from storage if it exists
        if ($submission->document_path) {
            Storage::disk('public')->delete($submission->document_path);
        }
        
        $submission->status = 'rejected';
        $submission->rejection_reason = $validatedData['rejection_reason'];
        
        // Clear document data since it's been deleted
        $submission->document_path = null;
        $submission->document_original_name = null;
        
        $submission->save();
        
        // Get the user associated with this submission
        $user = User::findOrFail($submission->user_id);
        
        // Send rejection email
        Mail::to($user->email)->send(new FormRejected($submission));
        
        return redirect()->route('admin.submissions')->with('success', 'Form has been rejected with reason provided and notification email has been sent to the applicant. Uploaded documents have been deleted.');
    }

    /**
     * View document associated with a form submission.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function viewDocument($id)
    {
        $submission = FormSubmission::findOrFail($id);
        
        if (!$submission->document_path) {
            return redirect()->back()->with('error', 'No document found for this submission.');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($submission->document_path)) {
            return redirect()->back()->with('error', 'The document file could not be found.');
        }
        
        // Return the file as a response
        return response()->file(storage_path('app/public/' . $submission->document_path));
    }

    /**
     * View a specific form submission in detail.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewSubmission($id)
    {
        $submission = FormSubmission::with('user')->findOrFail($id);
        return view('admin.view-submission', compact('submission'));
    }
}
