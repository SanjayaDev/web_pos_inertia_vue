<?php

use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\PermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render("Auth/Login");
})->middleware("guest");

Route::group(["middleware" => "auth"], function() {
    Route::get("/apps/dashboard", DashboardController::class)->name("apps.dashboard");

    Route::get("/apps/permissions", PermissionController::class)->name("apps.permissions.index")
    ->middleware("permission:permissions.index");
});