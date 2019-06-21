<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{user}', 'ProfileController@show')->name('profile.show');
    Route::patch('profile/edit', 'ProfileController@update')->name('profile.update');
});
