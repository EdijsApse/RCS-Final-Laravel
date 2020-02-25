<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'SiteController@index')->name('home');

Route::get('/contact', 'SiteController@contact');

Route::post('/contact', 'SiteController@store');

Route::get('/posts', 'PostController@index');

Route::get('/post/create', 'PostController@create')->middleware('auth');

Route::post('/post/create', 'PostController@store')->middleware('auth');

Route::get('/post/{post}', 'PostController@view');

Route::get('/post/{post}/edit', 'PostController@edit');

Route::post('/post/{post}', 'PostController@update')->middleware('auth');;

Route::post('/post/{post}/like', 'PostController@like')->middleware('auth');

Route::post('/post/{post}/comment', 'PostController@commentPost')->middleware('auth');

Route::get('/users', 'UserController@index');

Route::get('/user/{user}', 'UserController@view');

Route::get('profile/edit', 'UserController@edit')->middleware('auth');

Route::get('profile', 'UserController@profile')->middleware('auth');

Route::post('profile', 'UserController@update')->middleware('auth');

Auth::routes();
