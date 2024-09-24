<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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

    /**
     * Extracts the JobID from the Job string based on the pattern "YY-000" or "YY-0000".
     *
     * @param string|null $jobString
     * @return string|null
     */
    private function extractJobId($jobString)
    {
        if ($jobString) {
            // Use regex to match patterns like "YY-000" or "YY-0000"
            if (preg_match('/\b\d{2}-\d{3,4}\b/', $jobString, $matches)) {
                return $matches[0];
            }
        }

        // Return null if no match is found
        return null;
    }

}

