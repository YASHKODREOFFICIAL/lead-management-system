<?php

use App\Http\Controllers\Api\LeadApiController;
use Illuminate\Support\Facades\Route;

// Protected API route using Sanctum
Route::middleware('auth:sanctum')->post('/leads/create', [LeadApiController::class, 'store']);
