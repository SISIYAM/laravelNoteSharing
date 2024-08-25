<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\pageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminDeleteController;
use App\Http\Controllers\AdminUpdateController;
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
        Route::get('/admin/manage/contents/university/form/update/{slug?}','loadUpdateUniversityForm')->name('admin.form.update.university');
        Route::get('/admin/manage/reviews', 'loadReviews')->name('admin.reviews');
        Route::get('/admin/assign/materials','loadNotAssignedMaterials')->name('admin.assign.material');
        Route::get('/admin/assign/materials/pdfs','loadNotAssignedPdfs')->name('admin.assign.pdf');
        Route::get('/admin/manage/contents/materials/pdfs','loadPdfs')->name('admin.manage.pdf.list');
        Route::get('/admin/manage/contents/universites/departments','loadDepartments')->name('admin.manage.department.list');
        Route::get('/admin/manage/contents/universites/departments/update/{slug?}','loadUpdateDepartmentForm')->name('admin.manage.department.update');
    });

    // controller for update queries
    Route::controller(AdminUpdateController::class)->group(function () {
        Route::put('/admin/ajax/update/pdf','updatePdfAjax')->name('admin.ajax.update.pdf');
        Route::put('/admin/manage/update/materials/{slug}','updateMaterials')->name('admin.update.materials');
        Route::post('/admin/manage/update/semesters','updateSemesters')->name('admin.update.semester');
        Route::post('/admin/manage/update/semesters/add','addNewSemester')->name('admin.ajax.new.semester');
        Route::put('/admin/manage/contents/university/update/{slug}','updateUniversity')->name('admin.update.university');
        Route::post('/admin/assign/materials/semister','assignMaterials')->name('ajax.assing.materials.semister');
        Route::post('/admin/notassign/materials/','removeAssignedMaterial')->name('ajax.not.assing.materials.semister');
        Route::post('/admin/ajax/assign/pdf','assignPdfs')->name('admin.ajax.assign.pdf');
        Route::post('/admin/ajax/remove/assigned/pdf', 'removeAssignedPdf')->name('admin.ajax.not.assigned.pdf');
        Route::post('/admin/ajax/add/new/department', 'addNewDepartment')->name('admin.ajax.add.department');
        Route::post('/admin/ajax/update/new/department', 'updateDepartment')->name('admin.ajax.update.department');
        Route::put('/admin/manage/contents/universities/department/update/{slug?}','adminUpdateDepartment')->name('admin.update.department');
    });

    // controller for delete queries
    Route::controller(AdminDeleteController::class)->group(function () {
        Route::get('/admin/delete/faculties/{slug}','deleteFaculties')->name('admin.delete.faculties');
        Route::get('/admin/delete/pdf/{id}','deletePdf')->name('admin.delete.pdf');
        Route::post('/admin/delete/materials','deleteMaterials')->name('admin.delete.materials');
        Route::post('/admin/delete/university','deleteUniversity')->name('admin.delete.university');
        Route::post('/admin/delete/semester/selected','selectedSemesterDelete')->name('admin.delete.semester.selected');
        Route::get('/admin/delete/reviews/{id}','deleteReviews')->name('admin.delete.reviews');
        Route::get('/admin/delete/pdfs/{id}','deletePdfs')->name('admin.delete.pdfs');
        Route::post('/admin/delete/department/selected','deleteSelectedSemester')->name('admin.delete.department.selected');
        Route::get('/admin/delete/department/list/{id?}','deleteListDepartment')->name('admin.delete.list.department');
    });
});