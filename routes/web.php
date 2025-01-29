<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Aqui você pode retornar a view 'welcome'
})->name('welcome');

Route::get('/hello', function () {
    return 'Hello Honorio'; // Aqui você pode retornar a view 'welcome'
});

Route::get('/test/env', function () {
    dd(env('DB_DATABASE')); // Dump 'db' variable value one by one
});

// MIDDLEWARE PARA ESTA ROTA ESPECIFFICA
// PODE SER APENAS UM OU VÁRIOS
// A ORDEM DE EXECUCAO IMPORTA

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//AQUI ESTA DEFINIDA A middleware GUEST E AUTH
require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'] )->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin.update.password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', function () {
        return view('agent.agent_dashboard');
    })->name('agent.dashboard');
});

//Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::controller(PropertyTypeController::class)->group(function(){

   Route::get('/all/type', 'AllType')->name('all.type');
    Route::get('/add/type', 'AddType')->name('add.type');
    Route::post('/store/type', 'StoreType')->name('store.type');
    Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
    Route::post('/update/type', 'UpdateType')->name('update.type');
    Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
});
