<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisappearedPetController;
use App\Http\Controllers\FoundPetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PetDoctorController;
use App\Http\Controllers\PetDoctorReviewsController;
use App\Http\Controllers\PetSupplierController;
use App\Http\Controllers\PetSupplierReviewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/sign-up', [AuthController::class, 'sign_up']);
Route::post('/sign-in', [AuthController::class, 'sign_in']);
Route::post('/sign-out', [AuthController::class, 'sign_out'])->middleware('auth:sanctum');
Route::post('/edit-profile', [AuthController::class, 'edit_profile'])->middleware('auth:sanctum');
Route::post('/change-password', [AuthController::class, 'change_password'])->middleware('auth:sanctum');

Route::get('/pets', [PetController::class, 'index']);
Route::post('/pets', [PetController::class, 'store'])->middleware('auth:sanctum');
Route::get('/pets/{id}', [PetController::class, 'show'])->whereNumber('id');
Route::post('/pets/{id}', [PetController::class, 'update'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('/current-user/pets', [PetController::class, 'getCurrentUserPets'])->middleware('auth:sanctum');
Route::post('/pets/search-by-qr-code', [PetController::class, 'searchByQrCodeText']);

Route::get('/disappeared-pets', [DisappearedPetController::class, 'index']);
Route::post('/disappeared-pets', [DisappearedPetController::class, 'store'])->middleware('auth:sanctum');
Route::get('/disappeared-pets/{id}', [DisappearedPetController::class, 'show'])->whereNumber('id');
Route::post('/disappeared-pets/{id}', [DisappearedPetController::class, 'update'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('/disappeared-pets/{id}', [DisappearedPetController::class, 'destroy'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('/disappeared-pets/filter/{category}', [DisappearedPetController::class, 'filterByCategory'])->whereAlpha('category');
Route::get('/current-user/disappeared-pets', [DisappearedPetController::class, 'getCurrentUserDisappearedPets'])->middleware('auth:sanctum');
Route::post('/disappeared-pets/search-by-qr-code', [DisappearedPetController::class, 'searchByQrCodeText']);

Route::get('/found-pets', [FoundPetController::class, 'index']);
Route::post('/found-pets', [FoundPetController::class, 'store'])->middleware('auth:sanctum');
Route::get('/found-pets/{id}', [FoundPetController::class, 'show'])->whereNumber('id');
Route::post('/found-pets/{id}', [FoundPetController::class, 'update'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('/found-pets/{id}', [FoundPetController::class, 'destroy'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('/found-pets/filter/{category}', [FoundPetController::class, 'filterByCategory'])->whereAlpha('category');
Route::get('/current-user/found-pets', [FoundPetController::class, 'getCurrentUserFoundPets'])->middleware('auth:sanctum');
Route::post('/found-pets/search-by-qr-code', [FoundPetController::class, 'searchByQrCodeText']);

Route::get('/pet-doctors', [PetDoctorController::class, 'index']);
Route::post('/pet-doctors', [PetDoctorController::class, 'store']);
Route::get('/pet-doctors/{id}', [PetDoctorController::class, 'show'])->whereNumber('id');
Route::post('/pet-doctors/{id}', [PetDoctorController::class, 'update'])->whereNumber('id');
Route::delete('/pet-doctors/{id}', [PetDoctorController::class, 'destroy'])->whereNumber('id');

Route::get('/pet-doctor-reviews', [PetDoctorReviewsController::class, 'index']);
Route::post('/pet-doctor-reviews', [PetDoctorReviewsController::class, 'store']);
Route::get('/pet-doctor-reviews/{id}', [PetDoctorReviewsController::class, 'show'])->whereNumber('id');
Route::post('/pet-doctor-reviews/{id}', [PetDoctorReviewsController::class, 'update'])->whereNumber('id');
Route::delete('/pet-doctor-reviews/{id}', [PetDoctorReviewsController::class, 'destroy'])->whereNumber('id');

Route::get('/pet-suppliers', [PetSupplierController::class, 'index']);
Route::post('/pet-suppliers', [PetSupplierController::class, 'store']);
Route::get('/pet-suppliers/{id}', [PetSupplierController::class, 'show'])->whereNumber('id');
Route::post('/pet-suppliers/{id}', [PetSupplierController::class, 'update'])->whereNumber('id');
Route::delete('/pet-suppliers/{id}', [PetSupplierController::class, 'destroy'])->whereNumber('id');

Route::get('/pet-supplier-reviews', [PetSupplierReviewsController::class, 'index']);
Route::post('/pet-supplier-reviews', [PetSupplierReviewsController::class, 'store']);
Route::get('/pet-supplier-reviews/{id}', [PetSupplierReviewsController::class, 'show'])->whereNumber('id');
Route::post('/pet-supplier-reviews/{id}', [PetSupplierReviewsController::class, 'update'])->whereNumber('id');
Route::delete('/pet-supplier-reviews/{id}', [PetSupplierReviewsController::class, 'destroy'])->whereNumber('id');