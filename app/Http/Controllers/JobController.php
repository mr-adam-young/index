<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobStatus;
use App\Models\StatusCode;
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
        // Retrieve all jobs from the database with pagination
        $list = Job::paginate(30);
        
        // return it as a view instead
        return view('jobs.index', compact('list'));
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
        // Retrieve all the records from the StatusCodes table
        $JobStatuses = \App\Models\StatusCode::all();
        $laborEstimates = [];

        // Pass the job data to the view
        return view('jobs.show', compact('job', 'JobStatuses', 'laborEstimates'));
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
        // DB::connection()->statement("CALL ProjectSummary();");

        // Log the SQL query for debugging purposes
        // Log::info("CALL ProjectSummary();");

        // ->whereBetween('Status', [1, 99])

        // Retrieve the results from the database
        $jobs = DB::table('Jobs')->get();
        // 

        // Return the results as a JSON object
        // Log::debug("Retrieved active jobs: " . json_encode($jobs));
        return response()->json($jobs);
    }

    public function active()
    {
        $list = Job::active()->paginate(30);
        return view('jobs.active', compact('list'));
    }

    /**
     * Get a list of accounts (jobs).
     */
    public function getAccounts()
    {
        $jobs = Job::select('ID', 'Title')->get();

        return response()->json($jobs, 200);
    }

    /**
     * Get details of a specific job.
     */
    public function getJob(Request $request, $id)
    {
        $job = Job::with('statusCode')->find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found.'], 404);
        }

        return response()->json($job, 200);
    }

    /**
     * Update job status.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'job' => 'required|integer',
            'code' => 'required|integer',
        ]);

        $jobId = $request->input('job');
        $statusCode = $request->input('code');

        Log::info("Received status update request for JobID: $jobId with StatusCode: $statusCode");

        // Insert into JobStatus table
        JobStatus::create([
            'StatusJobID' => $jobId,
            'StatusCode' => $statusCode,
            'StatusDate' => now(),
        ]);

        // Update the job's status
        $job = Job::find($jobId);

        if (!$job) {
            return response()->json(['message' => 'Job not found.'], 404);
        }

        $job->Status = $statusCode;
        $job->lastUpdated = now();
        $job->save();

        return response()->json([
            'status' => $statusCode,
            'message' => 'Job status updated successfully.',
        ], 200);
    }

    // Additional methods can be added here as needed
}