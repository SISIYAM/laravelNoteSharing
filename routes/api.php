<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// api for frontEnd
Route::controller(apiController::class)->group(function () {

    Route::get('/request/fetch/universities','fetchUniversity');
    Route::get('/request/semesters','fetchSemesters');
    Route::get('/request/fetch/university/details/{slug?}','showUniversityDetails');
    Route::get('/request/fetch/university/semesters/materials/{slug?}','fetchMaterialsDetails');
    Route::get('/request/fetch/university/semesters/materials/pdf/{slug?}','fetchPdfDetails');
    Route::get('/request/fetch/search/{input?}', 'fetchSearch');
    Route::get('/request/fetch/faculties','fetchFaculties');
});