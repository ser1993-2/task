<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('user')->middleware(['isUser'])->group(function () {
    Route::get('/', 'UserController@index');
});

Route::prefix('manager')->middleware(['isManager'])->group(function () {
    Route::get('/', 'ManagerController@index');
});
