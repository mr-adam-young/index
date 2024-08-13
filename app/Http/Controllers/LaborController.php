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
}
