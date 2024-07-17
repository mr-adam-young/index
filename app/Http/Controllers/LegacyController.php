<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LegacyController extends Controller
{
    public function handleLegacy($path)
    {
        // Path to the legacy directory
        $legacyPath = base_path('legacy/' . $path);

        // Check if the file exists
        if (file_exists($legacyPath)) {
            // Capture the output
            ob_start();
            include $legacyPath;
            $content = ob_get_clean();

            // Return the content as a response
            return new Response($content);
        }

        // Return a 404 response if the file does not exist
        return abort(404);
    }
}
