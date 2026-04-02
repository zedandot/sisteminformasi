<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/bap', function () {
    return view('admin.bap.index');
});

Route::get('/admin/monitoring', function () {
    return view('admin.monitoring.index');
});
