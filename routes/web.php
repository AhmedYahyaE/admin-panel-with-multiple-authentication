<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, UserController, ProjectController, RoleController};



// Start Laravel Breeze Routes
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
// End Laravel Breeze Routes



// My Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function() {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/dashboared/users'   , [UserController::class, 'index'])->name('dashboard.users');
    Route::get('/dashboard/projects', [ProjectController::class, 'index'])->name('dashboard.projects');



    // Protect routes of managing roles (only accessible for 'admin' role) using Spatie Larvel Permission package's built-in middlewares
    Route::group(['middleware' => ['permission:edit roles']], function () { // 'role' is Spatie's middleware and 'admin' is a Middleware Paramter
        // Edit & Delete Roles of Users
        Route::get('/dashboard/users/{userModel}/edit-role', [UserController::class, 'showEditRoleForm'])->name('dashboard.users.edit-role');
        Route::post('/dashboard/users/{userModel}/edit-role', [UserController::class, 'editRole'])->name('dashboard.users.edit-role');
        Route::post('/dashboard/users/{userModel}/delete-role', [UserController::class, 'deleteRole'])->name('dashboard.users.delete-role'); // via AJAX

        // Create Roles & Permissions
        // Route::get('/dashboard/roles/create', [RoleController::class, 'showCreateRoleForm'])->name('dashboard.roles.create');
    });
});
