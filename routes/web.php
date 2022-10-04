<?php

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

Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'checkAuth'])->name('login.checkAuth');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [\App\Http\Controllers\Home\HomeController::class, 'logout'])->name("logout");
    // Home
    Route::get('/', [\App\Http\Controllers\Home\HomeController::class, 'index'])->name("home");
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Profile\ProfileController::class, 'index'])->name("profile.index");
    Route::post('/profile', [\App\Http\Controllers\Profile\ProfileController::class, 'store'])->name("profile.store");
    // Users
    Route::resource('/users', \App\Http\Controllers\Users\UsersController::class);
    // Terminal
    Route::resource('/terminals', \App\Http\Controllers\Terminals\TerminalsController::class);
    // Branches
    Route::get('/branches/run/{code}', [\App\Http\Controllers\Branches\BranchesController::class, "code"]);
    Route::post('/branches/import', [\App\Http\Controllers\Branches\BranchesController::class, "import"])->name('branches.import');
    Route::resource('/branches', \App\Http\Controllers\Branches\BranchesController::class);

    // Network
    Route::resource('/networks', \App\Http\Controllers\Networks\NetworkController::class);

    // Projects
    Route::resource('/projects', \App\Http\Controllers\Project\ProjectController::class);

    // Branch Level
    Route::resource('/levels', \App\Http\Controllers\Level\LevelController::class);

    // Branch Level
    Route::resource('/line-types', \App\Http\Controllers\LineType\LineTypeController::class);


    // Routers
    Route::resource('/routers', \App\Http\Controllers\Router\RouterController::class);

    // switch model
    Route::resource('/switch-model', \App\Http\Controllers\SwitchModel\SwitchModelController::class);

    // ups installations
    Route::resource('/ups-installations', \App\Http\Controllers\UpsInstallation\UpsInstaltionController::class);

    // line capacities
    Route::resource('/line-capacities', \App\Http\Controllers\LineCapaties\LineCapacityController::class);

    // entuity status
    Route::resource('/entuity-status', \App\Http\Controllers\EntuityStatus\EntuityStatusController::class);

    // governments
    Route::resource('/government', \App\Http\Controllers\Government\GovernmentController::class);
});
