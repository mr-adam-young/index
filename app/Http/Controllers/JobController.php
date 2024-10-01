<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Pass the job data to the view
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }

    public function getActiveJobs()
    {
        // Execute the stored procedure
        DB::connection()->statement("CALL ProjectSummary();");

        // Log the SQL query for debugging purposes
        // Log::info("CALL ProjectSummary();");

        // Retrieve the results from the database
        $jobs = DB::table('Jobs')
            ->join('StatusCodes', 'Jobs.Status', '=', 'StatusCodes.Value')
            ->whereBetween('Status', [1, 99])
            ->get();

        // Return the results as a JSON object
        return response()->json($jobs);
    }
}
