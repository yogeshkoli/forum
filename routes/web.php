<?php

Route::get('/', 'ThreadsController@index');

Route::get('threads', 'ThreadsController@index');
Route::get('threads/create', 'ThreadsController@create');
Route::post('threads', 'ThreadsController@store');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');