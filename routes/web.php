<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\pageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminDashboardController;


// routes for front end
Route::controller(pageController::class)->group(function () {
    Route::get('/','index')->name('home');
    Route::get('/university/details/{slug?}', 'showDetails')->name('details');
    Route::get('/university/details/semester/materials/{slug?}', 'showMaterials')->name('material.details');
    Route::get('/university/bsmraau/faculties','showFacultiesList')->name('faculties');
    Route::get('/university/details/semester/materials/pdf/details/{slug?}','loadPdf')->name('material.pdf');
    Route::post('ajax/search','loadSearchResult')->name('admin.ajax.search');
});

Route::get('/error/403', function () {
    return view('admin.layouts.forbitten');
})->name('error.403');


Route::controller(AuthController::class)->group(function(){
    Route::get('/auth/admin/register','loadRegister')->name('admin.load.register');
    Route::get('/auth/admin/login','loadLogin')->name('admin.load.login');
    Route::post('/auth/admin/execute/register','adminRegister')->name('admin.register');
    Route::post('/auth/admin/execute/login','adminLogin')->name('admin.login');
    Route::get('/logout','logout')->name('admin.logout');
});

// admin middleware
Route::middleware([AdminMiddleware::class])->group(function(){
    Route::controller(AdminDashboardController::class)->group(function(){
        Route::get('/admin/dashboard', 'loadDashboard')->name('admin.dashboard');
        Route::get('/admin/manage/contents/universities/','loadUniversities')->name('admin.manage.universities');
        Route::get('/admin/manage/contents/universities/form/add','loadUniversityForm')->name('admin.add.universities');
        Route::post('/admin/manage/contents/university/add','addUniversity')->name('admin.add.university');
        Route::get('/admin/manage/contents/universities/semesters','loadSemester')->name('admin.manage.universities.semesters');
        Route::post('/admin/manage/contents/universities/semesters/materials/add','addMaterials')->name('admin.add.materials');
        Route::get('/admin/manage/contents/universities/semesters/materials/form/add','loadMaterialsForm')->name('admin.form.materials');
        Route::post('/admin/jquery/ajax/universities/semesters', 'universitySemester')->name('admin.semester.ajax');
        Route::get('/admin/manage/contents/universities/semesters/materials','loadMaterials')->name('admin.manage.universities.semesters.materials');
        Route::get('/admin/manage/contents/universities/semesters/materials/form/update/{slug?}','loadMaterialsUpdateForm')->name('admin.update.materials.form');
        Route::get('/admin/manage/faculties', 'loadFaculties')->name('admin.faculties');
        Route::get('/admin/manage/faculties/form/add','loadFacultiesForm')->name('admin.form.faculties');
        Route::post('/admin/manage/faculties/add','addFaculties')->name('admin.add.faculties');
        Route::get('/admin/manage/faculties/form/update/{slug?}','loadFacultiesUpdateForm')->name('admin.form.update.faculties');
        Route::post('/admin/ajax/pdf','loadPdfInfo')->name('admin.ajax.pdf');
    });
});