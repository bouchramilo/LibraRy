<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;

// **********************************************************************************************************************************
Route::get("/login", [AuthController::class, 'index'])->name("auth.login.show");
Route::post("/login", [AuthController::class, 'store'])->name("auth.login.store");

// **********************************************************************************************************************************
Route::get("/register", [RegisteredUserController::class, 'index'])->name("auth.register.show");
Route::post("/register", [RegisteredUserController::class, 'store'])->name("auth.register.store");

// **********************************************************************************************************************************
Route::get("/profile", [ProfileController::class, 'index'])->name("auth.profile.show");
Route::put("/profile", [ProfileController::class, 'update'])->name("auth.profile.update");
Route::put("/profile/updatepassword", [ProfileController::class, 'updatepassword'])->name("auth.profile.update.password");
Route::delete("/profile/delete", [ProfileController::class, 'deleteProfile'])->name("auth.profile.delete");

