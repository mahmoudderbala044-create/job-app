<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_application;

class Job_ApllicationsController extends Controller
{
    public function index()
    {
       $applications = Job_application::where('user_id', auth()->id())->latest()->paginate(5);
        return view('job_applications.index', compact('applications'));
    }
}
