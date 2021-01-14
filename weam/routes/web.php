<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

// languages
Route::prefix('languages')->group(function() {

	Route::get('list','\App\Http\Controllers\Settings\LanguageController@availableLanguagesCodeAndLanguage');

	Route::get('available', '\App\Http\Controllers\Settings\LanguageController@availableLanguagesCode');

    Route::get('default','\App\Http\Controllers\Settings\LanguageController@defaultLanguage');

	Route::post('modify/{locale}', 'App\Http\Controllers\Settings\LanguageController@changeLanguage')->where('locale', '[a-z]{2}_[A-Z]{2}');

});

// TODO: add gzip/brotli support to the server, modify middleware SetEncoding and add 'encoding' as middleware to serve compressed ressources at user

// public views
Route::middleware(['translations', 'cache.headers:public;max_age=2628000;etag'])->group(function() {

	Route::get('/', 'App\Http\Controllers\Views\HomeController@index');

	//Route::get('/{any}', 'App\Http\Controllers\Views\HomeController@index')->where('any', '.*');

});

// user views
Route::middleware(['translations', 'cache.headers:public;max_age=2628000;etag', 'auth', 'verified'])->group(function() {

    Route::get('/settings', 'App\Http\Controllers\Views\SettingsController@index');

});

// authentication
Auth::routes(['verify' => true]);
