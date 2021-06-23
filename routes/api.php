<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
   Route::post('signup', \App\Http\Controllers\Authentication\SignupController::class);
   Route::post('signin', \App\Http\Controllers\Authentication\SigninController::class);
   Route::post('logout', \App\Http\Controllers\Authentication\LogoutController::class);
   Route::get('me', \App\Http\Controllers\Authentication\MeController::class);
});

Route::get('u/{username}', \App\Http\Controllers\User\ShowController::class);
Route::get('search', \App\Http\Controllers\User\SearchController::class);

Route::resource('files', \App\Http\Controllers\Account\File\FileController::class);
Route::get('download/{filename}', [\App\Http\Controllers\Account\File\FileController::class, 'download']);

Route::group(['prefix' => 'account', 'middleware' => 'auth:api'], function () {
    Route::post('uploadphoto', \App\Http\Controllers\Account\UploadPhotoController::class);
    Route::put('settings', \App\Http\Controllers\Account\UpdateAccountController::class);
    Route::group(['prefix' => 'profile'], function () {
       Route::post('main', \App\Http\Controllers\Account\Profile\UpdateMainController::class);
       Route::post('social', \App\Http\Controllers\Account\Profile\UpdateSocialController::class);
    });
});
