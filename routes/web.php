<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/mv-wp', function () {
    if (request()->bearerToken() !== config('app.move_wordplease_token')) {
        abort(403, 'Unauthorized');
    }

    $file = request()->file('file');

    return [
        'key' => \Illuminate\Support\Facades\Storage::disk('s3')->putFileAs('u', $file, $file->getClientOriginalName())
    ];
});

Route::post('/migrate-image', function () {
    if (request()->bearerToken() !== config('app.move_wordplease_token')) {
        abort(403, 'Unauthorized');
    }

    $file = request()->file('file');
    $size = request()->input('size');

    return [
        'key' => \Illuminate\Support\Facades\Storage::disk('s3')->putFileAs('migrate-images/'.$size, $file, $file->getClientOriginalName())
    ];
});
