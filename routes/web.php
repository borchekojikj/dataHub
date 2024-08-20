<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PageController;
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

Route::get('login-page', [PageController::class, 'loginPage'])->name('login');
Route::get('logout', [UserController::class, 'logoutUser'])->name('logout');
Route::post('user-login', [UserController::class, 'userLogin'])->name('user-login');


Route::middleware('auth')->group(function () {
    Route::post('save_data',  [PageController::class, 'saveData'])->name('save-data');
    Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/content', [App\Http\Controllers\PageController::class, 'content'])->name('content');
    Route::post('/update-content', [App\Http\Controllers\PageController::class, 'updateContent'])->name('update-content');
    Route::post('/update-socials', [App\Http\Controllers\PageController::class, 'updateSocials'])->name('update-socials');
    Route::get('/faqs', [App\Http\Controllers\PageController::class, 'showFAQs'])->name('faqs');
    Route::post('/create-faqs', [App\Http\Controllers\PageController::class, 'createFAQs'])->name('create-faqs');
    Route::post('/update-faqs', [App\Http\Controllers\PageController::class, 'updateFAQs'])->name('update-faqs');
    Route::get('/delete-faqs/{id}', [App\Http\Controllers\PageController::class, 'deleteFAQs'])->name('delete-faqs');
    Route::get('/user-questions', [App\Http\Controllers\PageController::class, 'showUserQuestions'])->name('user-questions');
    Route::get('/delete-user-question/{id}', [App\Http\Controllers\PageController::class, 'deleteUserQuestion'])->name('delete-user-question');
    Route::post('/answer-user-question', [App\Http\Controllers\PageController::class, 'answerUserQuestion'])->name('answer-user-question');
    Route::get('/subscribed-users', [App\Http\Controllers\PageController::class, 'showSubscribedUsers'])->name('subscribed-users');
    Route::get('/delete-subscribed-user/{id}', [App\Http\Controllers\PageController::class, 'deleteSubscribedUser'])->name('delete-subscribed-user');
    Route::get('/blogs', [App\Http\Controllers\PageController::class, 'blogs'])->name('blogs');
    Route::post('/post-blog', [App\Http\Controllers\PageController::class, 'postBlog'])->name('post-blog');
    Route::get('/delete-blog/{id}', [App\Http\Controllers\PageController::class, 'deleteBlog'])->name('delete-blog');
    Route::get('/change-blog-status/{id}', [App\Http\Controllers\PageController::class, 'changeBlogStatus'])->name('change-blog-status');


    Route::get('/catalogues', [App\Http\Controllers\PageController::class, 'showCatalogues'])->name('catalogues');
    Route::post('/store-catalogue', [App\Http\Controllers\PageController::class, 'storeCatalogue'])->name('store-catalogue');
    Route::get('/delete-catalogue/{id}', [App\Http\Controllers\PageController::class, 'deleteCatalaogue'])->name('delete-catalogue');

    Route::get('/change-catalogue-status/{id}', [App\Http\Controllers\PageController::class, 'changeCatalogueStatus'])->name('change-catalogue-status');
});
