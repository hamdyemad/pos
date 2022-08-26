<?php

use Illuminate\Support\Facades\Route;


Route::group([
'prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'
]], function() {
    Route::group(['middleware' => 'guest'], function() {
        Route::redirect('/', '/admin/login');
        Route::post('/admin/login', 'Auth\LoginController@login')->name('login');
        Route::get('/admin/login', function() {
            return view('auth.login');
        })->name('admin_login');
    });
});



