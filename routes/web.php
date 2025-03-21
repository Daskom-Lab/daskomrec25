<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AdminSessionController;
use App\Http\Controllers\Auth\CaasSessionController;
use App\Http\Controllers\UserAsistenController;
use App\Http\Controllers\UserCaasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlottinganController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\Auth\AdminProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'CaAs.LandingCaas');
    Route::get('login', [CaasSessionController::class, 'index'])->name('caas.login');
    Route::post('login', [CaasSessionController::class, 'store'])->name('caas.login.authenticate');
    Route::get('admin/login', [AdminSessionController::class, 'index'])->name('admin.login');
    Route::post('admin/login', [AdminSessionController::class, 'store'])->name('admin.login.authenticate');
});

Route::middleware(['auth', 'caas'])->group(function () {
    // Halaman home-nya CAAS
    Route::view('home', 'CaAs.HomePageCaAs')->name('caas.home');

    // Logout CAAS
    Route::post('logout', [CaasSessionController::class, 'destroy'])->name('caas.logout');

    // Form ganti password
    Route::view('change-password', 'CaAs.ChangePassword')->name('caas.change-password');

    // Proses ganti password
    Route::post('change-password', [CaasSessionController::class, 'updatePassword'])
        ->name('caas.change-password.update');

    // Profile CAAS
    Route::view('profile', 'CaAs.ProfileCaAs')->name('caas.profile');

    // Pengumuman
    Route::view('announcement', 'CaAs.Announcement')->name('caas.announcement');

    // Kontak asisten 
    Route::view('assistants', 'CaAs.AssistansPage')->name('caas.assistants');

    Route::get('choose-shift', [PlottinganController::class, 'chooseShiftView'])->name('caas.choose-shift');
    Route::post('shift/pick',   [PlottinganController::class, 'pickShift'])->name('caas.shift.pick');
    Route::get('shift',         [PlottinganController::class, 'fixShiftView'])->name('caas.fix-shift');

    // Pemilihan Gem
    Route::get('choose-gem', [UserCaasController::class, 'chooseGemView'])->name('caas.choose-gem');
    Route::post('pick-gem', [UserCaasController::class, 'pickGem'])->name('caas.pick-gem');
    Route::get('gem', [UserCaasController::class, 'fixGemView'])->name('caas.fix-gem');
});

Route::view('/admin', 'secret');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('home', 'admin.home')->name('home');

    Route::get('/plots', function () {
        return response()->json(
            App\Models\Shift::orderBy('date', 'asc')
                ->orderBy('time_start', 'asc')
                ->withCount('plottingans')
                ->with(['plottingans.caas.user.profile'])
                ->get()
        );
    });

    // Reset Shift & Plot
    Route::post('/shift/reset-shifts', [ShiftController::class, 'resetShifts'])->name('shift.resetShifts');
    Route::post('/shift/reset-plot', [ShiftController::class, 'resetPlot'])->name('shift.resetPlot');

    // View Plot
    Route::get('/view-plot', [PlottinganController::class, 'viewPlot'])->name('view-plot');
    Route::get('/view-plot/{id}', [PlottinganController::class, 'show'])->name('view-plot.show');
    Route::delete('/plottingans/{id}', [App\Http\Controllers\PlottinganController::class, 'destroy'])
        ->name('plottingan.delete');
    Route::get('/plot/havenpicked', [App\Http\Controllers\PlottinganController::class, 'havenPicked'])
        ->name('plot.havenpicked');

    // Route untuk menampilkan halaman assign schedule untuk CAAS tertentu
    Route::get('/plot/assign-schedule/{caas}', [\App\Http\Controllers\PlottinganController::class, 'assignSchedule'])
        ->name('plot.assign-schedule');

    // Route untuk menyimpan jadwal yang dipilih
    Route::post('/plot/assign-schedule', [\App\Http\Controllers\PlottinganController::class, 'storeAssignedSchedule'])
        ->name('plot.assign-schedule.store');

    Route::post('/shift/import', [ShiftController::class, 'importShift'])->name('shift.import');
    Route::get('/shift/export-pdf', [ShiftController::class, 'exportPdf'])->name('shift.export.pdf');
    Route::get('/shift/export-excel', [ShiftController::class, 'exportExcel'])->name('shift.export.excel');
    Route::get('/plot/export-pdf', [PlottinganController::class, 'exportPdf'])->name('plot.export.pdf');

    // User caas import/export excel
    Route::post('/caas/import', [UserCaasController::class, 'importCaas'])->name('caas.import');
    Route::get('/caas/export', [UserCaasController::class, 'exportCaas'])->name('caas.export');

    // RESET PASSWORD ADMIN
    Route::get('/reset-password', [AdminProfileController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AdminProfileController::class, 'updatePassword'])->name('reset-password.update');
    Route::post('logout', [AdminSessionController::class, 'destroy'])->name('logout');

    $resources = [
        'announcement' => AnnouncementController::class,
        'shift' => ShiftController::class,
        'asisten' => UserAsistenController::class,
        'caas' => UserCaasController::class,
        'gems' => RoleController::class,
        'stage' => StageController::class,
        'dashboard' => DashboardController::class,
    ];

    foreach ($resources as $key => $controller) {
        Route::resource($key, $controller)
            ->only(['index', 'store', 'destroy', 'update', 'show'])
            ->names([
                'index' => "$key",
                'store' => "$key.store",
                'destroy' => "$key.delete",
                'update' => "$key.update",
                'show' => "$key.show",
            ]);
    }
});


Route::fallback(function () {
    return redirect()->route('caas.login');
});
