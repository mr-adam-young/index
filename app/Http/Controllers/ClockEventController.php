<?php

namespace App\Http\Controllers;

use App\Models\ClockEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Staff;
use App\Models\Job;
use Carbon\Carbon;

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

    // process the clock events into new job and staff records
    public function generateWorkSummary()
    {
        // Fetch all unprocessed ClockEvents
        $clockEvents = ClockEvent::where('is_processed', 0)
            ->orderBy('clock_time')
            ->get();

        foreach ($clockEvents as $event) {
            // Process Staff
            $staff = Staff::firstOrCreate(
                ['email' => $event->email],
                [
                    'first_name' => $event->first_name,
                    'last_name'  => $event->last_name,
                    // Add other necessary fields
                ]
            );

            // Extract job identifier (format: YY-XXX)
            $jobIdentifier = null;
            if (preg_match('/\b\d{2}-\d{3}\b/', $event->job_name, $matches)) {
                $jobIdentifier = $matches[0];

                // Check if the job exists, create if not
                $job = Job::firstOrCreate(
                    ['identifier' => $jobIdentifier],
                    ['name' => $event->job_name]
                );
            } else {
                // Skip jobs without the specified identifier format
                continue;
            }

            // Parse clock time
            $clockTime = Carbon::createFromFormat('n/j/Y G:i', $event->clock_time);
            $hoursWorked = 0;

            // If this is a clock out event, calculate the hours worked since the last clock in
            if (!$event->is_clock_in) {
                // Find the most recent clock-in event for this employee on the same job and task
                $previousClockInEvent = ClockEvent::where('email', $event->email)
                    ->where('job_name', $event->job_name)
                    ->where('task_name', $event->task_name)
                    ->where('is_clock_in', 1)
                    ->where('clock_time', '<', $event->clock_time)
                    ->orderBy('clock_time', 'desc')
                    ->first();

                if ($previousClockInEvent) {
                    $clockInTime = Carbon::createFromFormat('n/j/Y G:i', $previousClockInEvent->clock_time);
                    $hoursWorked = $clockTime->diffInHours($clockInTime);
                }
            }

            // Create a new LaborNew entry if hours worked is greater than 0
            if ($hoursWorked > 0) {
                LaborNew::create([
                    'Hours'       => $hoursWorked,
                    'LaborTypeID' => 1, // Assuming 1 is a default value, you may map this based on tasks
                    'Timestamp'   => $clockTime->toDateTimeString(),
                    'Date'        => $clockTime->toDateString(),
                    'EmployeeID'  => $staff->id, // Assuming Staff model has an 'id' field
                    'JobID'       => $job->id,   // Assuming Job model has an 'id' field
                    'Migrated'    => 0,          // Assuming this field is always 0 for new entries
                    'description' => $event->notes // Assuming the 'notes' field can be used as description
                ]);
            }

            // Mark the event as processed
            $event->is_processed = 1;
            $event->save();
        }

        return response()->json(['message' => 'Work summary processed and inserted into LaborNew']);
    }

}