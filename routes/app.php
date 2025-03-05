<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\Parameterization\OperatingUnitController;
use App\Http\Controllers\App\Security_options\ProfileController;
use App\Http\Controllers\App\Manage_your_Account\PersonController;
use App\Http\Controllers\App\Manage_your_Account\ChangePasswordController;

Route::get('LoginOtherBrowser', [HomeController::class, 'LoginOtherBrowser']);
Route::get('LogoutByLoginOtherBrowser', [HomeController::class, 'LogoutByLoginOtherBrowser']);

Route::group(['middleware' => ['validateauthsession']], function () {
    Route::get('', [HomeController::class, 'index']);
    Route::get('dashboard', [HomeController::class, 'dashboard']);

    Route::resource('Manage_your_Account/Personal_information', PersonController::class);
    Route::get('Manage_your_Account/Personal_information.show/{id}', [PersonController::class, 'show'])->name('Manage_your_Account/Personal_information.show');
    Route::get('Manage_your_Account/Personal_information.edit/{id}', [PersonController::class, 'edit'])->name('Manage_your_Account/Personal_information.edit');

    Route::resource('Manage_your_Account/Change_of_password', ChangePasswordController::class);
    Route::get('Manage_your_Account/Change_of_password.show/{id}', [ChangePasswordController::class, 'show'])->name('Manage_your_Account/Change_of_password.show');
    Route::get('Manage_your_Account/Change_of_password.edit/{id}', [ChangePasswordController::class, 'edit'])->name('Manage_your_Account/Change_of_password.edit');

    Route::resource('operatingUnit', OperatingUnitController::class);
    Route::get('operatingUnit.show/{id}', [OperatingUnitController::class, 'show'])->name('operatingUnit.show');
    Route::get('operatingUnit.edit/{id}', [OperatingUnitController::class, 'edit'])->name('operatingUnit.edit');
    Route::get('operatingUnit.save', [OperatingUnitController::class, 'save'])->name('operatingUnit.save');

    Route::resource('profile', ProfileController::class);
    Route::get('profile.show/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile.edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
});
