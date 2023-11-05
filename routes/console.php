<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use chillerlan\QRCode\QRCode;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('ulid', function () {
    $this->comment(\App\Models\Subject::ulid());
})->purpose('Display a ulid');

// take input from the user and make a new subject with a 'title' attribute
Artisan::command('subject', function () {
    $title = $this->ask('What is the title of the subject?');
    $subject = new \App\Models\Subject();
    $subject->title = $title;
    $subject->save();
    $this->comment('Subject created with title: ' . $subject->title);

    // generate a QR code for the subject
    $prefix = 'https://index.one/';
    $url = $prefix . $subject->ulid;
    $subject->url = $url;
    $subject->save();
    $qrCode = new QRCode();
    $qrCode->render($url, 'storage/app/public/' . $subject->id . '.png');
    $this->comment('QR code generated at: ' . $subject->id . '.png');

    // use GD to render the title and QR code together
    $im = imagecreatetruecolor(400, 400);
    $white = imagecolorallocate($im, 255, 255, 255);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagefill($im, 0, 0, $white);
    imagestring($im, 5, 10, 10, $subject->title, $black);
    $qr = imagecreatefrompng('storage/app/public/' . $subject->id . '.png');
    imagecopy($im, $qr, 10, 30, 0, 0, 380, 380);
    imagepng($im, 'storage/app/public/' . $subject->id . '.png');
    $this->comment('QR code rendered with title at: ' . $subject->id . '.png');
})->purpose('Create a new subject');