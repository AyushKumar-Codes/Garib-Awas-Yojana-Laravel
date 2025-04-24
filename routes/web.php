<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Static Pages
Route::get('/schemes', function () {
    return view('schemes');
});

Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

// Contact Form Submission
Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');

// Authentication Routes
Auth::routes();

// User Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/form', [FormSubmissionController::class, 'create'])->name('form');
Route::post('/submit-form', [FormSubmissionController::class, 'store'])->name('submit-form');

// Application Tracking Routes
Route::get('/track', [FormSubmissionController::class, 'showTrackForm'])->name('track.form');
Route::post('/track', [FormSubmissionController::class, 'trackApplication'])->name('track.application');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/submissions', [AdminController::class, 'showSubmissions'])->name('admin.submissions');
    Route::get('/users', [AdminController::class, 'showUsers'])->name('admin.users');
    Route::get('/form/{id}/accept', [AdminController::class, 'acceptForm'])->name('admin.accept-form');
    Route::get('/form/{id}/reject', [AdminController::class, 'showRejectForm'])->name('admin.show-reject-form');
    Route::post('/form/{id}/reject', [AdminController::class, 'rejectForm'])->name('admin.reject-form');
    Route::get('/form/{id}/document', [AdminController::class, 'viewDocument'])->name('admin.view-document');
    Route::get('/form/{id}/view', [AdminController::class, 'viewSubmission'])->name('admin.view-submission');
    
    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/download/all', [ReportController::class, 'downloadAllApplicationsCsv'])->name('admin.reports.download.all');
    Route::get('/reports/download/{status}', [ReportController::class, 'downloadByStatusCsv'])->name('admin.reports.download.status');
    Route::get('/reports/download/monthly/{month}/{year}', [ReportController::class, 'downloadMonthlyReportCsv'])->name('admin.reports.download.monthly');
    Route::get('/reports/api/latest-data', [ReportController::class, 'getLatestData'])->name('admin.reports.api.latest-data');
    
    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::put('/contacts/{contact}/mark-as-read', [ContactController::class, 'markAsRead'])->name('admin.contacts.mark-as-read');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
});

// Redirect /admin to admin dashboard
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});
