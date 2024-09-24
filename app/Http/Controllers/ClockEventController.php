<?php

namespace App\Http\Controllers;

use App\Models\ClockEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClockEventController extends Controller
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
        // Retrieve the JSON data from the request
        $data = $request->json()->all();

        // Prepare the data for insertion into the clock_events table
        $insertData = [
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'clock_time' => isset($data['clock_time']) ? date('Y-m-d H:i:s', strtotime($data['clock_time'])) : null,
            'clock_lat' => $data['clock_lat'] ?? null,
            'clock_long' => $data['clock_long'] ?? null,
            'job_name' => $data['job_name'] ?? null,
            'task_name' => $data['task_name'] ?? null,
            'notes' => $data['notes'] ?? null,
            'is_clock_in' => $data['is_clock_in'] ?? true,
        ];

        // Insert the data into the clock_events table
        DB::table('clock_events')->insert($insertData);

        return response()->json(['message' => 'Data successfully inserted'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClockEvent $clockEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClockEvent $clockEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClockEvent $clockEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClockEvent $clockEvent)
    {
        //
    }

    public function capturePostData(Request $request)
    {
        // Capture all POST data
        $postData = $request->all();

        // Process the POST data as needed
        // For example, you can log the data or save it to the database

        // Return a response
        return response()->json(['message' => 'Data received', 'data' => $postData], 200);
    }
}
