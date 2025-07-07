<?php

use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Purchase\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resources(['invoices'=>InvoiceController::class]);
Route::resources(['purchases'=>PurchaseController::class]);
