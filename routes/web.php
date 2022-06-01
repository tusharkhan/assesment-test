<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return sendResponse(
        'Welcome to the Laravel API',
        [
            'data' => [
                'version' => '1.0.0',
                'author' => 'Touficul Islam'
            ]
        ]
    );
});


Route::get('/unauthorized', function () {
    return sendError(
        'Unauthorized',
        [
        'error' => trans('Unauthorized Attempt')
    ],\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
})->name('unauthorized');
