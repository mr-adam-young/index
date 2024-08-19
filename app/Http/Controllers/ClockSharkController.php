<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClockSharkController extends Controller
{
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
