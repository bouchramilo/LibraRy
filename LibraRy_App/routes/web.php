<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Librarian\CategoriesController;
use App\Http\Controllers\Librarian\UsersController;
use App\Http\Middleware\BibliothecaireMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// **********************************************************************************************************************************
Route::get("/home", [HomeController::class, 'index'])->name("home");

// **********************************************************************************************************************************

// **********************************************************************************************************************************

// Routes pour les bibliothécaires
Route::middleware(BibliothecaireMiddleware::class)->group(function () {
// gestion des catégories :
    Route::get("/admin/categories", [CategoriesController::class, 'index'])->name("manage.categories.index");
    Route::post("/admin/categories", [CategoriesController::class, 'store'])->name("manage.categories.store");
    Route::delete("/admin/categories/{category_id}", [CategoriesController::class, 'destroy'])->name("manage.categories.delete");
// gestion des Clients :
    Route::get("/admin/users", [UsersController::class, 'index'])->name("manage.users.index");
    Route::delete("/admin/users/{user_id}", [UsersController::class, 'destroy'])->name("manage.users.delete");
});
// **********************************************************************************************************************************
require __DIR__ . '/auth.php';
