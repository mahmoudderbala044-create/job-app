<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index()
    {
       $applications = JobApplication::where('user_id', auth()->id())->latest()->paginate(5);
        return view('job_applications.index', compact('applications'));
    }
}
