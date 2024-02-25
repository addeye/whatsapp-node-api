<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('dologin', [AuthController::class, 'doLogin']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('doregister', [AuthController::class, 'doRegister']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::post('dologout', [AuthController::class, 'dologout'])->name('dologout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resources([
        'user' => UserController::class,
        'device' => DeviceController::class,
        'group' => GroupController::class
    ]);

    Route::get('setting', [SettingController::class, 'index']);
    Route::post('setting', [SettingController::class, 'save']);

    Route::post('group-create/{group}', [GroupController::class, 'createGroup']);
    Route::get('device-create', [DeviceController::class, 'deviceCreate']);

    Route::resource('group.participant', ParticipantController::class)->shallow();
    Route::post('participant-import', [ParticipantController::class, 'import']);

    Route::get('user-export', [UserController::class, 'export']);
    Route::get('device-export', [DeviceController::class, 'export']);
    Route::get('group-export', [GroupController::class, 'export']);
    Route::get('participant-export', [ParticipantController::class, 'export']);
});
