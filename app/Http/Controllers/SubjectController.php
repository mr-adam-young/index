<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class SubjectController extends Controller
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
    public function create(Request $request)
    {
        // Create a new Subject with a ULID as primary key
        $subject = Subject::create([
            'name' => $request->input('name'),
        ]);

        // Generate the URL for the subject
        $url = route('subject.show', ['id' => $subject->id]);

        // Generate the QR code
        $qrCode = (new QRCode(new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_H,
        ])))->render($url);

        // Define the file path
        $filePath = "qrcodes/{$subject->id}.png";

        // Store the QR code in the storage path
        Storage::disk('local')->put($filePath, $qrCode);

        // Return response with subject details and QR code path
        return response()->json([
            'subject' => $subject,
            'qr_code_url' => asset("storage/{$filePath}"),
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
