<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PageController;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;








Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);



// Route::middleware('auth:sanctum')->group(function () {

Route::get('/products', [PageController::class, 'getFilteredProducts']);
Route::get('/get-categories', [PageController::class, 'getAllCategories']);
Route::get('/get-brands', [PageController::class, 'getAllBrands']);
Route::get('/get-faqs', [PageController::class, 'getAllFAQs']);
Route::post('/logout', [UserController::class, 'logout']);
// Route::get('/update-content', [PageController::class, 'updateContent']);
Route::post('/subscribe-user', [PageController::class, 'subscribeUser']);
Route::get('/get-catalogues', [PageController::class, 'getAllCatalogues']);
Route::get('/get-blogs', [PageController::class, 'getAllBlogs']);
// });
