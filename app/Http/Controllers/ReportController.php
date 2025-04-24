<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Generate reports page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get real-time counts directly from the database
        $pendingCount = FormSubmission::where('status', 'pending')->count();
        $acceptedCount = FormSubmission::where('status', 'accepted')->count();
        $rejectedCount = FormSubmission::where('status', 'rejected')->count();
        $totalCount = FormSubmission::count(); // Directly count all submissions
        
        // Get total regular users count
        $totalUsers = User::where('role', 'user')->count();
        
        // Get current timestamp for refresh indication
        $lastRefreshed = now();
        
        // Get monthly stats for the current year
        $currentYear = date('Y');
        $monthlyStats = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $pending = FormSubmission::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'pending')
                ->count();
                
            $accepted = FormSubmission::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'accepted')
                ->count();
                
            $rejected = FormSubmission::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'rejected')
                ->count();
            
            $monthlyStats[$month] = [
                'pending' => $pending,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'total' => $pending + $accepted + $rejected,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1))
            ];
        }
        
        // Get latest submissions for quick reference - most recent first
        $latestSubmissions = FormSubmission::with('user')
            ->latest()
            ->take(10)
            ->get();
            
        // Get top 5 users with most submissions
        $topUsers = User::where('role', 'user')
            ->withCount('formSubmissions')
            ->orderBy('form_submissions_count', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.reports.index', compact(
            'pendingCount', 
            'acceptedCount', 
            'rejectedCount', 
            'totalCount',
            'totalUsers',
            'monthlyStats',
            'latestSubmissions',
            'topUsers',
            'lastRefreshed'
        ));
    }
    
    /**
     * Download all applications as CSV.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadAllApplicationsCsv(Request $request)
    {
        $submissions = FormSubmission::with('user')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="all-applications-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, [
                'ID',
                'Tracking ID',
                'Applicant Name',
                'Email',
                'Address',
                'Aadhar Number',
                'Annual Income',
                'Document Type',
                'Status',
                'Rejection Reason',
                'Submission Date',
                'Last Updated'
            ]);
            
            // Add data rows
            foreach ($submissions as $submission) {
                $documentType = '';
                
                switch ($submission->document_type) {
                    case 'aadhar_card':
                        $documentType = 'Aadhar Card';
                        break;
                    case 'pan_card':
                        $documentType = 'PAN Card';
                        break;
                    case 'driving_license':
                        $documentType = 'Driving License';
                        break;
                    case 'income_certificate':
                        $documentType = 'Income Certificate';
                        break;
                    default:
                        $documentType = $submission->document_type;
                }
                
                fputcsv($file, [
                    $submission->id,
                    $submission->tracking_id,
                    $submission->name,
                    $submission->user->email,
                    $submission->address,
                    $submission->aadhar_number,
                    $submission->annual_income,
                    $documentType,
                    ucfirst($submission->status),
                    $submission->rejection_reason,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Download applications by status as CSV.
     *
     * @param Request $request
     * @param string $status
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadByStatusCsv(Request $request, $status)
    {
        if (!in_array($status, ['pending', 'accepted', 'rejected', 'all'])) {
            abort(404);
        }
        
        if ($status === 'all') {
            return $this->downloadAllApplicationsCsv($request);
        }
        
        $submissions = FormSubmission::with('user')
            ->where('status', $status)
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $status . '-applications-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, [
                'ID',
                'Tracking ID',
                'Applicant Name',
                'Email',
                'Address',
                'Aadhar Number',
                'Annual Income',
                'Document Type',
                'Status',
                'Rejection Reason',
                'Submission Date',
                'Last Updated'
            ]);
            
            // Add data rows
            foreach ($submissions as $submission) {
                $documentType = '';
                
                switch ($submission->document_type) {
                    case 'aadhar_card':
                        $documentType = 'Aadhar Card';
                        break;
                    case 'pan_card':
                        $documentType = 'PAN Card';
                        break;
                    case 'driving_license':
                        $documentType = 'Driving License';
                        break;
                    case 'income_certificate':
                        $documentType = 'Income Certificate';
                        break;
                    default:
                        $documentType = $submission->document_type;
                }
                
                fputcsv($file, [
                    $submission->id,
                    $submission->tracking_id,
                    $submission->name,
                    $submission->user->email,
                    $submission->address,
                    $submission->aadhar_number,
                    $submission->annual_income,
                    $documentType,
                    ucfirst($submission->status),
                    $submission->rejection_reason,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Download monthly report as CSV.
     *
     * @param Request $request
     * @param int $month
     * @param int $year
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadMonthlyReportCsv(Request $request, $month, $year)
    {
        $submissions = FormSubmission::with('user')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();
        
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $monthName . '-' . $year . '-report.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($submissions, $monthName, $year) {
            $file = fopen('php://output', 'w');
            
            // Add report title
            fputcsv($file, [$monthName . ' ' . $year . ' - Housing Applications Report']);
            fputcsv($file, ['Generated on: ' . date('Y-m-d H:i:s')]);
            fputcsv($file, []);
            
            // Add CSV header
            fputcsv($file, [
                'ID',
                'Tracking ID',
                'Applicant Name',
                'Email',
                'Address',
                'Aadhar Number',
                'Annual Income',
                'Document Type',
                'Status',
                'Rejection Reason',
                'Submission Date',
                'Last Updated'
            ]);
            
            // Add data rows
            foreach ($submissions as $submission) {
                $documentType = '';
                
                switch ($submission->document_type) {
                    case 'aadhar_card':
                        $documentType = 'Aadhar Card';
                        break;
                    case 'pan_card':
                        $documentType = 'PAN Card';
                        break;
                    case 'driving_license':
                        $documentType = 'Driving License';
                        break;
                    case 'income_certificate':
                        $documentType = 'Income Certificate';
                        break;
                    default:
                        $documentType = $submission->document_type;
                }
                
                fputcsv($file, [
                    $submission->id,
                    $submission->tracking_id,
                    $submission->name,
                    $submission->user->email,
                    $submission->address,
                    $submission->aadhar_number,
                    $submission->annual_income,
                    $documentType,
                    ucfirst($submission->status),
                    $submission->rejection_reason,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            // Add summary
            fputcsv($file, []);
            fputcsv($file, ['Summary']);
            fputcsv($file, ['Total Applications', $submissions->count()]);
            fputcsv($file, ['Pending Applications', $submissions->where('status', 'pending')->count()]);
            fputcsv($file, ['Accepted Applications', $submissions->where('status', 'accepted')->count()]);
            fputcsv($file, ['Rejected Applications', $submissions->where('status', 'rejected')->count()]);
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Get the latest report data as JSON for real-time updates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestData()
    {
        $data = [
            'pendingCount' => FormSubmission::where('status', 'pending')->count(),
            'acceptedCount' => FormSubmission::where('status', 'accepted')->count(), 
            'rejectedCount' => FormSubmission::where('status', 'rejected')->count(),
            'totalCount' => FormSubmission::count(),
            'totalUsers' => User::where('role', 'user')->count(),
            'lastRefreshed' => now()->format('M d, Y, h:i:s A')
        ];
        
        return response()->json($data);
    }
}
