<?php

use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Librarian\BookController;
use App\Http\Controllers\Librarian\ExemplaireController;
use App\Http\Controllers\LibrarianDashboardController;
use App\Http\Controllers\Librarian\CategoriesController;
use App\Http\Controllers\Librarian\UsersController;
use App\Http\Middleware\BibliothecaireMiddleware;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/404', function () {
    return view('404');
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
    Route::put("/admin/categories/{category_id}", [CategoriesController::class, 'update'])->name("manage.categories.update");

// gestion des Clients :
    Route::get("/admin/users", [UsersController::class, 'index'])->name("manage.users.index");
    Route::get('/admin/users/filter', [UsersController::class, 'filter'])->name('admin.users.filter');
    Route::delete("/admin/users/{user_id}", [UsersController::class, 'destroy'])->name("manage.users.delete");
    Route::put("/admin/users", [UsersController::class, 'updateStatus'])->name("manage.users.status");

// gestion de dashboard de admin
    Route::get("/admin/dashboard", [LibrarianDashboardController::class, 'index'])->name("librarian.dashboard");

// gestion de books
    Route::get("/admin/books", [BookController::class, 'index'])->name("librarian.books.index");
    Route::get("/admin/books/add", [BookController::class, 'create'])->name("librarian.books.create");
    Route::post("/admin/books/add", [BookController::class, 'store'])->name("admin.books.store");
    Route::get("/admin/books/details/{book_id}", [BookController::class, 'show'])->name("admin.books.show");
    Route::get("/admin/books/edit/{book_id}", [BookController::class, 'edit'])->name("admin.books.edit");
    Route::put("/admin/books/{book}", [BookController::class, 'update'])->name("admin.books.update");
    Route::delete('/admin/books/delete/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

    // gestion de books
    Route::get("/admin/exemplaires", [ExemplaireController::class, 'index'])->name("librarian.exemplaires.index");
    Route::get("/admin/exemplaires/add", [ExemplaireController::class, 'create'])->name("librarian.exemplaires.create");
    Route::post("/admin/exemplaires/add", [ExemplaireController::class, 'store'])->name("librarian.exemplaires.store");

});

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// **********************************************************************************************************************************
Route::middleware(ClientMiddleware::class)->group(function () {

// gestion de dashboard de client
    Route::get("/client/dashboard", [ClientDashboardController::class, 'index'])->name("client.dashboard");

});
// **********************************************************************************************************************************
require __DIR__ . '/auth.php';
