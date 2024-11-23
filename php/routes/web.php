<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Faculty\FacultyController as MainFacultyController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Faculty\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Faculty\ReservationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login.form');

Route::get('register-type', [AuthController::class, 'showRegisterType'])->name('register.type');
Route::get('register/student', [AuthController::class, 'showStudentRegisterForm'])->name('register.student');
Route::get('register/faculty', [AuthController::class, 'showFacultyRegisterForm'])->name('register.faculty');

Route::post('register/student', [AuthController::class, 'registerStudent'])->name('register.student.post');
Route::post('register/faculty', [AuthController::class, 'registerFaculty'])->name('register.faculty.post');

Route::prefix('auth')->namespace('App\Http\Controllers')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::resource('admins', AdminController::class);
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [AdminController::class, 'showProfile'])->name('showProfile'); // Show profile
    Route::put('profile', [AdminController::class, 'updateProfile'])->name('updateProfile'); // Update profile
    Route::put('password', [AdminController::class, 'updatePassword'])->name('updatePassword'); // Change password
    Route::resource('admins', AdminController::class);
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::resource('faculties', FacultyController::class );
    Route::resource('feedbacks', AdminFeedbackController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('roomTypes', RoomTypeController::class);
    Route::resource('events', EventController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::delete('reservations/{id}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('reservations/{id}', [AdminReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::get('reports/reservation-utilization', [ReportController::class, 'reservationUtilization'])->name('reports.reservationUtilization');
    Route::get('reports/event-participation', [ReportController::class, 'eventParticipation'])->name('reports.eventParticipation');
    Route::get('reports/faculty-activity', [ReportController::class, 'facultyActivity'])->name('reports.facultyActivity');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});


Route::prefix('student')->middleware('auth:student')->name('student.')->group(function () {
    Route::get('dashboard', [MainStudentController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [MainStudentController::class, 'showProfile'])->name('showProfile'); // Show profile
    Route::put('profile', [MainStudentController::class, 'updateProfile'])->name('updateProfile'); // Update profile
    Route::put('password', [MainStudentController::class, 'updatePassword'])->name('updatePassword'); // Change password
    Route::post('events/{event_id}/register', [AttendanceController::class, 'registerAttendance'])->name('attendance.register');

});

// Faculty routes
Route::prefix('faculty')->middleware('auth:faculty')->name('faculty.')->group(function () {

    Route::get('dashboard', [MainFacultyController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [MainFacultyController::class, 'showProfile'])->name('showProfile'); // Show profile
    Route::put('profile', [MainFacultyController::class, 'updateProfile'])->name('updateProfile'); // Update profile
    Route::put('password', [MainFacultyController::class, 'updatePassword'])->name('updatePassword');
    Route::get('rooms/{id}', [MainFacultyController::class, 'showRoom'])->name('rooms.show');
    Route::post('rooms/{id}/feedbacks', [FeedbackController::class, 'addNewFeedback'])->name('rooms.feedback.addNewFeedback');
    Route::delete('rooms/{id}/feedbacks', [FeedbackController::class, 'deleteFeedback'])->name('rooms.feedback.delete');
    Route::get('rooms/{id}/reservation', [ReservationController::class, 'showBookingPage'])->name('rooms.book');
    Route::post('rooms/{id}/reservation', [ReservationController::class, 'confirmReservation'])->name('rooms.confirmReservation');
    Route::post('rooms/{id}/cancel', [ReservationController::class, 'cancelReservation'])->name('rooms.cancel');

});
