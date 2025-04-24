<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $submissions = FormSubmission::where('user_id', $user->id)->get();
        
        // Sample previous schemes for demonstration
        $previousSchemes = [
            [
                'name' => 'Pradhan Mantri Awas Yojana (PMAY)',
                'description' => 'Housing for All by 2022 initiative by the Government of India',
                'launch_year' => '2015',
            ],
            [
                'name' => 'Indira Awaas Yojana (IAY)',
                'description' => 'A social welfare programme to provide housing for the rural poor',
                'launch_year' => '1985',
            ],
            [
                'name' => 'Basic Services for Urban Poor (BSUP)',
                'description' => 'Aimed at improving the living conditions of urban poor',
                'launch_year' => '2005',
            ],
        ];
        
        return view('home', compact('submissions', 'previousSchemes'));
    }
}
