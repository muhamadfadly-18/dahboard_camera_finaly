<?php

use Illuminate\Support\Facades\Route;

// Route for the default login page
Route::get('/', function () {
    return view('auth.admin.login');
})->name('login');

// Login route for handling POST request
Route::post('/login', 'Auth\LoginController@login')->name('login.post');

// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.auth.login');
    Route::post('login', 'Auth\Admin\LoginController@login')->name('admin.auth.loginAdmin');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
    Route::get('logout', 'Auth\Admin\LoginController@logout');
});

// User Auth
Route::prefix('user')->group(function () {
    Route::get('login', 'Auth\User\LoginController@showLoginForm')->name('user.auth.login');
    Route::post('login', 'Auth\User\LoginController@login')->name('user.auth.loginUser');
    Route::post('logout', 'Auth\User\LoginController@logout')->name('user.auth.logout');
    Route::get('logout', 'Auth\User\LoginController@logout');
});

// Admin Dashboard
Route::group([
    'namespace' => 'Backend\Admin',
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth:admin'
], function () {
    require base_path('routes/backend/admin.php');
});

// User Dashboard
Route::group([
    'namespace' => 'Backend\User',
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => 'auth:user'
], function () {
    require base_path('routes/backend/user.php');
});

// Download template
Route::get('/download/template', function () {
    $filePath = storage_path('app/public/template.xlsx');

    if (!Storage::exists('public/template.xlsx')) {
        abort(404);
    }

    return Response::download($filePath);
});
