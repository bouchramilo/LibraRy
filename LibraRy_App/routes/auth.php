<?php

use App\Http\Controllers\Librarian\UsersController;

// **********************************************************************************************************************************
Route::get("/login", [UsersController::class, 'showLogin'])->name("auth.login.show");
Route::post("/login", [UsersController::class, 'login'])->name("auth.login.store");

// **********************************************************************************************************************************
Route::get("/register", [UsersController::class, 'showRegister'])->name("auth.register.show");
Route::post("/register", [UsersController::class, 'register'])->name("auth.register.store");

// **********************************************************************************************************************************
Route::get("/profile", [UsersController::class, 'showProfile'])->name("auth.profile.show");
Route::put("/profile", [UsersController::class, 'updateProfile'])->name("auth.profile.update");
Route::put("/profile/updatepassword", [UsersController::class, 'updatepassword'])->name("auth.profile.update.password");
Route::delete("/profile/delete", [UsersController::class, 'deleteAccount'])->name("auth.profile.delete");

// **********************************************************************************************************************************
Route::post("/logout", [UsersController::class, 'logout'])->name("auth.logout");

// **********************************************************************************************************************************

