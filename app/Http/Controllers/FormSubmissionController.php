<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Mail\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormSubmissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new submission.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        // Check if user already has 5 or more active applications
        $user = Auth::user();
        $activeSubmissionCount = FormSubmission::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->count();
            
        if ($activeSubmissionCount >= 5) {
            return redirect()->route('home')->with('error', 'You already have 5 active applications. You cannot submit more until some of your existing applications are processed or rejected.');
        }
        
        return view('form');
    }

    /**
     * Store a newly created submission in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check active submissions count again as a safeguard
        $activeSubmissionCount = FormSubmission::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->count();
            
        if ($activeSubmissionCount >= 5) {
            return redirect()->route('home')->with('error', 'You already have 5 active applications. You cannot submit more until some of your existing applications are processed or rejected.');
        }
        
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'aadhar_number' => 'required|string|size:12',
            'annual_income' => 'required|numeric|min:0',
            'message' => 'nullable|string|max:1000',
            'document_type' => 'required|string|in:aadhar_card,pan_card,driving_license,income_certificate',
            'document' => 'required|file|mimes:pdf|max:2048', // 2MB max
        ]);
        
        // Add user_id to the validated data
        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'pending';
        
        // Generate a unique tracking ID
        $trackingId = $this->generateTrackingId();
        $validatedData['tracking_id'] = $trackingId;
        
        // Handle document upload
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $document = $request->file('document');
            $originalName = $document->getClientOriginalName();
            $documentPath = $document->storeAs(
                'documents/' . Auth::id() . '/' . $trackingId,
                Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.pdf',
                'public'
            );
            
            // Add document information to validated data
            $validatedData['document_path'] = $documentPath;
            $validatedData['document_original_name'] = $originalName;
        }
        
        // Remove the document from validated data since it's not a column in the database
        unset($validatedData['document']);
        
        // Create the form submission
        $formSubmission = FormSubmission::create($validatedData);
        
        // Send confirmation email
        Mail::to(Auth::user()->email)->send(new FormSubmitted($formSubmission));
        
        return redirect()->route('home')->with('success', 'Your housing scheme application has been submitted successfully. Your tracking ID is ' . $trackingId . '. We will review your application and get back to you soon.');
    }

    /**
     * Generate a unique tracking ID.
     *
     * @return string
     */
    private function generateTrackingId()
    {
        $prefix = 'RH-' . date('Ym') . '-';
        $suffix = strtoupper(Str::random(6));
        $trackingId = $prefix . $suffix;
        
        // Ensure the tracking ID is unique
        while (FormSubmission::where('tracking_id', $trackingId)->exists()) {
            $suffix = strtoupper(Str::random(6));
            $trackingId = $prefix . $suffix;
        }
        
        return $trackingId;
    }

    /**
     * Track an application using tracking ID.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showTrackForm()
    {
        return view('track-form');
    }

    /**
     * Process tracking request and display results.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function trackApplication(Request $request)
    {
        $validatedData = $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $formSubmission = FormSubmission::where('tracking_id', $validatedData['tracking_id'])->first();

        if (!$formSubmission) {
            return redirect()->back()->with('error', 'No application found with this tracking ID. Please verify and try again.');
        }

        return view('track-result', compact('formSubmission'));
    }
}
