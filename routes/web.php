<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ChairmanMessageController;
use App\Http\Controllers\DirectorMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\FeeReceiptController;
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

    // Sliders
    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
    Route::put('/sliders/{slider}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('/sliders/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    Route::post('/sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::post('/testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');

    // FAQs
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
    Route::post('/faqs/{faq}/toggle', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');

    // Chairman Message
    Route::get('/chairman-message', [ChairmanMessageController::class, 'index'])->name('chairman-message.index');
    Route::post('/chairman-message', [ChairmanMessageController::class, 'storeOrUpdate'])->name('chairman-message.store');

    // Director Message
    Route::get('/director-message', [DirectorMessageController::class, 'index'])->name('director-message.index');
    Route::post('/director-message', [DirectorMessageController::class, 'storeOrUpdate'])->name('director-message.store');

    // Backend Courses (use /admin prefix)
   
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
   

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/gallery/{gallery}/toggle', [GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');

    // Blogs (Backend)
    Route::resource('blogs', BlogController::class);
    Route::post('/blogs/{blog}/toggle', [BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');

    // General Settings
    Route::get('/general', [GeneralSettingController::class, 'index'])->name('general-settings');
    Route::post('/general', [GeneralSettingController::class, 'storeOrUpdate'])->name('general-settings.update');

    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
Route::get('/students/{student}/admission-form', [StudentController::class, 'downloadAdmissionForm'])->name('students.admission-form');
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


    // results
      Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::post('/results', [ResultController::class, 'store'])->name('results.store');
    Route::put('/results/{result}', [ResultController::class, 'update'])->name('results.update');
    Route::delete('/results/{result}', [ResultController::class, 'destroy'])->name('results.destroy');
    Route::post('/results/{result}/toggle', [ResultController::class, 'toggleStatus'])->name('results.toggle-status');

Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/generate/{id}/{type}', [CertificateController::class, 'generate'])->name('certificates.generate');
// Form 5 Certificate Generate Route (GET method with ID)
Route::get('/form5/generate/{id}', [CertificateController::class, 'generateForm5'])->name('form5.generate');


    Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::post('/global', [SeoController::class, 'updateGlobal'])->name('global.update');
    Route::post('/page/{pageName}', [SeoController::class, 'updatePage'])->name('page.update');
    Route::post('/course/{id}', [SeoController::class, 'updateCourse'])->name('course.update');

    // If using PUT (Recommended)
// Route::put('/seo/course/{id}', [SeoController::class, 'updateCourse'])->name('course.update');

// OR if you are using POST, keep it as POST, but ensure the name matches:
Route::post('/seo/course/{id}', [SeoController::class, 'updateCourse'])->name('course.update');
});


Route::prefix('fees')->name('fees.')->group(function () {
    Route::get('/', [FeeReceiptController::class, 'index'])->name('index');
    Route::get('/create', [FeeReceiptController::class, 'create'])->name('create');
    Route::post('/', [FeeReceiptController::class, 'store'])->name('store');
    

    Route::put('/{receipt}', [FeeReceiptController::class, 'update'])->name('update');
    Route::delete('/{receipt}', [FeeReceiptController::class, 'destroy'])->name('destroy');
    
    Route::get('/{id}/print', [FeeReceiptController::class, 'print'])->name('print');
    Route::get('/student/{id}', [FeeReceiptController::class, 'getStudentDetails'])->name('student.details');
});

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

