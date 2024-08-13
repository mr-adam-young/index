<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LaborController extends Controller
{
    public function logPostData(Request $request)
    {
        // Log all POST data
        Log::info('POST data:', $request->all());

        return response()->json(['message' => 'Data logged successfully']);
    }

    public function store(Request $request)
    {
        // Retrieve the JSON data from the request
        $data = $request->json()->all();

        // Prepare the data for insertion
        $insertData = [
            'JobID' => $this->getJobId($data['Job'] ?? $data['job']), // Assuming you have a method to get JobID from Job name
            'EmployeeID' => $this->getEmployeeId($data['Name'] ?? $data['employee']), // Assuming you have a method to get EmployeeID from Name
            'Timestamp' => $data['Timestamp'] ?? $data['timestamp'],
            'Date' => date('Y-m-d', strtotime($data['Timestamp'] ?? $data['timestamp'])), // Extract the date from the timestamp
            'LaborTypeID' => $this->getLaborTypeId($data['Task'] ?? $data['task']), // Assuming you have a method to get LaborTypeID from Task
            'Hours' => $this->calculateHours($data['Timestamp'] ?? $data['timestamp']), // Assuming a method to calculate hours
            'StampIn' => $data['coords'] ?? null, // Storing coords in StampIn if that makes sense for your schema
            'StampOut' => null, // Assuming StampOut is not provided
            'Migrated' => 0 // Default value for Migrated
        ];

        // Insert the data into the LaborNew table
        DB::table('LaborNew')->insert($insertData);

        return response()->json(['message' => 'Data successfully inserted'], 201);
    }

}

