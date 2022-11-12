<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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
    Route::resource('/users', \App\Http\Controllers\Users\UsersController::class)->middleware("permission:Branche_read-users");

    // roles
    Route::resource('/roles', \App\Http\Controllers\Roles\RoleController::class)->middleware("permission:Branche_read-roles");

    // Terminal
    Route::resource('/terminals', \App\Http\Controllers\Terminals\TerminalsController::class)->middleware("permission:Branche_read-terminal");
    // Branches
    Route::get('/branches/run/{code}', [\App\Http\Controllers\Branches\BranchesController::class, "code"])->middleware("permission:Branche_terminal-branches");
    Route::get('/branches/commander/{branch}', [\App\Http\Controllers\Branches\BranchesController::class, "commander"])->name("branches.commander")->middleware("permission:Branche_terminal-branches");
    Route::post('/branches/cmd', [\App\Http\Controllers\Branches\BranchesController::class, "execute"])->name('branches.cmd')->middleware("permission:Branche_terminal-branches");
    Route::post('/branches/import', [\App\Http\Controllers\Branches\BranchesController::class, "import"])->name('branches.import')->middleware("permission:Branche_import-branches");
    Route::get('/branches/download', [\App\Http\Controllers\Branches\BranchesController::class, 'downloadTemplate'])->name('branches.downloadTemplate')->middleware("permission:Branche_export-branches");
    Route::get('/branches/get-datatable', [\App\Http\Controllers\Branches\BranchesController::class, 'getData'])->name('branches.getData')->middleware("permission:Branche_read-branches");
    Route::resource('/branches', \App\Http\Controllers\Branches\BranchesController::class)->middleware("permission:Branche_read-branches");

    // Network
    Route::resource('/networks', \App\Http\Controllers\Networks\NetworkController::class)->middleware("permission:Branche_read-network");

    // Projects
    Route::resource('/projects', \App\Http\Controllers\Project\ProjectController::class)->middleware("permission:Branche_read-project");

    // Branch Level
    Route::resource('/levels', \App\Http\Controllers\Level\LevelController::class)->middleware("permission:Branche_read-level");

    // Branch Level
    Route::resource('/line-types', \App\Http\Controllers\LineType\LineTypeController::class)->middleware("permission:Branche_read-line-type");


    // Routers
    Route::resource('/routers', \App\Http\Controllers\Router\RouterController::class)->middleware("permission:Branche_read-router-type");

    // switch model
    Route::resource('/switch-model', \App\Http\Controllers\SwitchModel\SwitchModelController::class)->middleware("permission:Branche_read-switch-model");

    // ups installations
    Route::resource('/ups-installations', \App\Http\Controllers\UpsInstallation\UpsInstaltionController::class)->middleware("permission:Branche_read-ups-installation");

    // line capacities
    Route::resource('/line-capacities', \App\Http\Controllers\LineCapaties\LineCapacityController::class)->middleware("permission:Branche_read-line-capacity");

    // entuity status
    Route::resource('/entuity-status', \App\Http\Controllers\EntuityStatus\EntuityStatusController::class)->middleware("permission:Branche_read-entuity-status");

    // governments
    Route::resource('/government', \App\Http\Controllers\Government\GovernmentController::class)->middleware("permission:Branche_read-government");

/*
    Route::get('/reset_db', function(){
        Branch::truncate();
    });
    Route::get('/drop_db', function(){
        Schema::dropIfExists('branches');

    });*/
});
