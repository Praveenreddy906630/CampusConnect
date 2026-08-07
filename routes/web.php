<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;

// Auth & Controllers
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\SotyController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\AdminCoordinatorController;
use App\Http\Controllers\CoordinatorDashboardController;
use App\Http\Controllers\StudentExportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\EventImportExportController;

// Middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckRegistrationPeriod;
use App\Http\Middleware\CoordinatorMiddleware;

// ---------------------------
// Public Routes
// ---------------------------

// ---------------------------
// Registration Period Restricted Routes
// ---------------------------
Route::middleware([CheckRegistrationPeriod::class])->group(function () {

    // Public Events
    Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');

    // Public Coordinators
    Route::get('/coordinators', [CoordinatorController::class, 'publicIndex'])->name('coordinators.public');

    // AJAX: Get Student Details
    Route::post('/get-student-details', function (Request $request) {
        $student = Student::where('enroll_no', $request->enrolment_no)->first();

        if ($student) {
            return response()->json([
                'success' => true,
                'data' => [
                    'full_name'    => $student->full_name,
                    'program_code' => $student->program_code,
                    'semester'     => $student->semester,
                    'gender'       => $student->gender,
                    'school_name'  => $student->school_name,
                    'email'        => $student->email,
                ],
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Enrolment not found']);
    });

    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Event Registration
    Route::middleware(['auth', CheckRegistrationPeriod::class])->group(function () {
        Route::get('/events/{event}/register', [EventRegistrationController::class, 'show'])->name('event.register');
        Route::post('/events/{event}/register', [EventRegistrationController::class, 'register'])->name('event.register.submit');
    });
    // User Registrations
    Route::get('/my-registrations', [EventRegistrationController::class, 'myRegistrations'])
        ->name('my.registrations')
        ->middleware('auth');

    // SOTY Apply (Authenticated)
    Route::middleware('auth')->group(function () {
        Route::get('/soty/apply', [SotyController::class, 'create']);
        Route::post('/soty/apply', [SotyController::class, 'store']);
        Route::delete('/admin/soty/{id}', [SotyController::class, 'destroy'])->name('admin.soty.destroy');
    });
});

// Authentication
Route::get('/login', fn() => view('auth.login'))->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ---------------------------
// Admin Routes
// ---------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Events
    Route::delete('events/delete-all', [EventController::class, 'deleteAll'])
        ->name('events.deleteAll');
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('admin/events', App\Http\Controllers\Admin\EventController::class);
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);

    // Registrations
    Route::get('/registrations', [App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{eventId}', [App\Http\Controllers\Admin\RegistrationController::class, 'show'])->name('registrations.show');
    Route::delete('/registrations/{id}', [App\Http\Controllers\Admin\RegistrationController::class, 'destroy'])->name('registrations.destroy');
    Route::delete('/registrations/event/{event}', [App\Http\Controllers\Admin\RegistrationController::class, 'deleteAll'])->name('registrations.deleteAll');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/delete-all', [UserController::class, 'deleteAll'])->name('users.deleteAll');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // SOTY
    Route::get('/soty', [SotyController::class, 'index'])->name('soty.index');
    Route::delete('/soty/delete-all', [SotyController::class, 'deleteAll'])->name('soty.deleteAll');
    Route::delete('/soty/{id}', [SotyController::class, 'destroy'])->name('soty.destroy');

    // Events Import 
    Route::get('/events/export', [EventImportExportController::class, 'export'])->name('events.export');
    Route::post('/events/import', [EventImportExportController::class, 'import'])->name('events.import');

    // Coordinators
    Route::get('/coordinators', [AdminCoordinatorController::class, 'index'])->name('coordinators.index');
    Route::get('/coordinators/create', [AdminCoordinatorController::class, 'create'])->name('coordinators.create');
    Route::post('/coordinators', [AdminCoordinatorController::class, 'store'])->name('coordinators.store');
    Route::delete('/coordinators/{id}', [AdminCoordinatorController::class, 'destroy'])->name('coordinators.destroy');
    Route::get('/coordinators/{id}/edit', [AdminCoordinatorController::class, 'edit'])->name('coordinators.edit');
    Route::put('/coordinators/{id}', [AdminCoordinatorController::class, 'update'])->name('coordinators.update');

    // Students Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/export', [StudentExportController::class, 'export'])->name('students.export');
    Route::post('/students/import', [StudentExportController::class, 'import'])->name('students.import');
    Route::delete('/students/delete-all', [StudentController::class, 'deleteAll'])->name('students.deleteAll');

    // Admin Management
    Route::get('/admins', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('admins.index');
    Route::get('/admins/{admin}/edit', [AdminUserController::class, 'edit'])->name('admins.edit');
    Route::get('/admins/create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('admins.create');
    Route::post('/admins', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('admins.store');
    Route::put('/admins/{admin}', [AdminUserController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('admins.destroy');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.view');
});

// ---------------------------
// Coordinator Routes (Public)
/// ---------------------------
Route::prefix('coordinator')->group(function () {
    Route::get('/dashboard', [CoordinatorController::class, 'dashboard'])->name('coordinator.dashboard');
    Route::get('/registrations', [CoordinatorController::class, 'registrations'])->name('coordinator.registrations');
    Route::post('/email-participants', [CoordinatorController::class, 'emailParticipants'])->name('coordinator.email');
});

// ---------------------------
// Coordinator Routes (Protected by CoordinatorMiddleware)
// ---------------------------
Route::prefix('coordinator')->middleware([CoordinatorMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [CoordinatorDashboardController::class, 'index'])
        ->name('coordinator.coordinator_dashboard');

    Route::get('/my-events', [CoordinatorDashboardController::class, 'myevents'])
        ->name('coordinator.dashboard');

    // Participants for a specific event
    Route::get('/participants/{event}', [CoordinatorDashboardController::class, 'participants'])
        ->name('coordinator.participants');

    // Export CSV for a specific event
    Route::get('/participants/{event}/export', [CoordinatorDashboardController::class, 'exportParticipants'])
        ->name('coordinator.participants.export');

    // Send mail to participants of a specific event
    Route::post('/mail/{event}', [CoordinatorDashboardController::class, 'sendMail'])
        ->name('coordinator.mail');

    Route::delete(
        'participants/{event}/{participant}',
        [CoordinatorDashboardController::class, 'deleteParticipant']
    )
        ->name('coordinator.participant.delete');

    Route::get('participants/{event}/export', [CoordinatorDashboardController::class, 'exportParticipants'])->name('coordinator.participants.export');
    Route::post('participants/{event}/import', [CoordinatorDashboardController::class, 'importParticipants'])->name('coordinator.participants.import');

    Route::get('/coordinator/event/{event}/export', [CoordinatorDashboardController::class, 'exportParticipants'])
        ->name('coordinator.participants.export');
});

Route::get('/coordinators', [CoordinatorController::class, 'publicIndex'])->name('coordinators.public');
Route::get('/coordinators/{id}', [CoordinatorController::class, 'publicShow'])->name('coordinators.show');
Route::view('/contact', 'contact');
Route::get('/', [HomeController::class, 'index']);

