<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Company;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query=JobVacancy::query();


        if ($request->filled('type') && $request->type !== 'all_types') {
            $query->where('type', $request->type);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', "%$request->search%")
            ->orWhere('location', 'like', "%$request->search%")
            ->orWhereHas('company', function ($query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            });
        }

        $jobs= $query->latest()->paginate(10)->withQueryString();
        
        return view('dashboard',compact('jobs'));
    }
}