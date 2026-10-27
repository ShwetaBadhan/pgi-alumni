<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\RegistrationTypeController;
use App\Http\Controllers\AlumniRegistrationController;

Route::get('/', function () {
    return view('frontend.pages.index');
})->name('home');

Route::get('/about-us', function () {
    return view('frontend.pages.about-us');
})->name('about-us');

Route::get('/objectives', function () {
    return view('frontend.pages.objectives');
})->name('objectives');

Route::get('/constitution', function () {
    return view('frontend.pages.constitution');
})->name('constitution');

Route::get('/membership', function () {
    return view('frontend.pages.membership');
})->name('membership');

Route::get('/overseas-founding-members', function () {
    return view('frontend.pages.overseas-founding-members');
})->name('overseas-founding-members');

Route::get('/national-founding-members', function () {
    return view('frontend.pages.national-founding-members');
})->name('national-founding-members');

Route::get('/alumni-publications', function () {
    return view('frontend.pages.alumni-publications');
})->name('alumni-publications');

Route::get('/executive-committee', function () {
    return view('frontend.pages.executive-committee');
})->name('executive-committee');

Route::get('/international-awards', function () {
    return view('frontend.pages.international-awards');
})->name('international-awards');

Route::get('/national-awards', function () {
    return view('frontend.pages.national-awards');
})->name('national-awards');

Route::get('/alumni-summit', function () {
    return view('frontend.pages.alumni-summit');
})->name('alumni-summit');

Route::get('/contact-us', function () {
    return view('frontend.pages.contact-us');
})->name('contact-us');

Route::get('/terms-and-condition', function () {
    return view('frontend.pages.terms-and-condition');
})->name('terms-and-condition');

Route::get('/refund-and-cancellation', function () {
    return view('frontend.pages.refund-and-cancellation');
})->name('refund-and-cancellation');

Route::get('/our-privacy-policy', function () {
    return view('frontend.pages.our-privacy-policy');
})->name('our-privacy-policy');

Route::get('/currency-conversion-policy', function () {
    return view('frontend.pages.currency-conversion-policy');
})->name('currency-conversion-policy');

Route::get('/hotels-accommodations', function () {
    return view('frontend.pages.hotels-accommodations');
})->name('hotels-accommodations');

Route::get('/alumni-registration', function () {
    return view('frontend.pages.alumni-registration');
})->name('alumni-registration');

Route::get('/get-your-membership-id', function () {
    return view('frontend.pages.get-your-membership-id');
})->name('get-your-membership-id');

Route::get('/registration-new', function () {
    return view('frontend.pages.registration-new');
})->name('registration-new');

Route::get('/alumni-login', function () {
    return view('frontend.pages.alumni-login');
})->name('alumni-login');



// ==========================================
// 1. AUTHENTICATION ROUTES (Top Priority)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});

// ==========================================
// 3. AUTHENTICATED ROUTES (Backend/Dashboard)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Dashboard
   
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

   // Roles & Permissions
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/{role}/permissions', [RoleController::class, 'getPermissionsModal'])->name('roles.permissions.modal');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

    // Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    

// Registration Types CRUD
Route::resource('registration-types', RegistrationTypeController::class)->names('registration-types');

Route::middleware(['auth'])->group(function () {
    Route::get('alumni-registrations/export', [AlumniRegistrationController::class, 'export'])->name('alumni-registrations.export');
    
    // Alumni Registrations CRUD
    Route::resource('alumni-registrations', AlumniRegistrationController::class)->names('alumni-registrations');
    Route::post('alumni-registrations/{alumniRegistration}/approve', [AlumniRegistrationController::class, 'approve'])->name('alumni-registrations.approve');
    Route::post('alumni-registrations/{alumniRegistration}/reject', [AlumniRegistrationController::class, 'reject'])->name('alumni-registrations.reject');
Route::post('alumni-registrations/{alumniRegistration}/send-email', [AlumniRegistrationController::class, 'sendEmail'])->name('alumni-registrations.send-email');
    });


// ==========================================
// 4. CATCH-ALL COURSE ROUTE (MUST BE LAST)
// ==========================================
Route::get('/{slug}', [HomeController::class, 'courseDetails'])
     ->where('slug', '[a-zA-Z0-9\-]+')
     ->name('course.details');

});