<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/account')->middleware(['auth'])->group(function () {
    Route::get('/', 'AccountController@getUser');
});

Route::prefix('user')->middleware(['isUser'])->group(function () {
    Route::get('/', 'UserController@index');

    Route::prefix('task')->middleware(['isUser'])->group(function () {
        Route::get('/{userId}', 'TaskController@getAllTasksForUser');
        Route::post('/', 'TaskController@createNewTask');
    });
});

Route::prefix('manager')->middleware(['isManager'])->group(function () {
    Route::get('/', 'ManagerController@index');
});
