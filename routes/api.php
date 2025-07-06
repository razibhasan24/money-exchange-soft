<?php

use App\Http\Controllers\api\Invoice\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route:: apiResources(['invoices'=>InvoiceController::class]);
