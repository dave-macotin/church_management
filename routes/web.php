<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\People\MemberController;
use App\Http\Controllers\Admin\People\FamilyController;
use App\Http\Controllers\Admin\People\GroupController;
use App\Http\Controllers\Admin\Ministry\EventController;
use App\Http\Controllers\Admin\Ministry\AttendanceController;
use App\Http\Controllers\Admin\Finance\DonationController;
use App\Http\Controllers\Admin\Finance\ExpenseController;
use App\Http\Controllers\Admin\Finance\AssetController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\SermonController;
use App\Http\Controllers\ChildCheckInController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\MemberDonationController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Member\MemberAttendanceController;
use App\Http\Controllers\Member\MemberEventsController;
use App\Http\Controllers\Member\MemberGroupsController;
use App\Http\Controllers\Member\MemberFamilyController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffMemberController;
use App\Http\Controllers\Staff\StaffFamilyController;
use App\Http\Controllers\Staff\StaffGroupController;
use App\Http\Controllers\Staff\StaffEventController;
use App\Http\Controllers\Staff\StaffAttendanceController;
use App\Http\Controllers\Staff\StaffSermonController;
use App\Http\Controllers\Staff\StaffVolunteerController;
use App\Http\Controllers\Staff\StaffCheckInController;

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if ($user = auth()->user()) {
        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('member.dashboard'),
        };
    }
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin-Only Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users & Settings
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',                       [AdminUserController::class, 'index'])  ->name('index');
        Route::patch('/{user}/approve',       [AdminUserController::class, 'approve'])->name('approve');
        Route::delete('/{user}',              [AdminUserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/settings',  [SettingsController::class, 'index']) ->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Finance
    Route::prefix('donations')->name('donations.')->group(function () {
        Route::get('/',                  [DonationController::class, 'index'])  ->name('index');
        Route::get('/create',            [DonationController::class, 'create']) ->name('create');
        Route::post('/',                 [DonationController::class, 'store'])  ->name('store');
        Route::delete('/{donation}',     [DonationController::class, 'destroy'])->name('destroy');
        Route::get('/archived',          [DonationController::class, 'archived'])->name('archived');
        Route::post('/restore/{id}',     [DonationController::class, 'restore'])->name('restore');
    });

    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/',               [ExpenseController::class, 'index'])  ->name('index');
        Route::get('/create',         [ExpenseController::class, 'create']) ->name('create');
        Route::post('/',              [ExpenseController::class, 'store'])  ->name('store');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])  ->name('edit');
        Route::patch('/{expense}',    [ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}',   [ExpenseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('assets')->name('assets.')->group(function () {
        Route::get('/',              [AssetController::class, 'index'])  ->name('index');
        Route::get('/create',        [AssetController::class, 'create']) ->name('create');
        Route::post('/',             [AssetController::class, 'store'])  ->name('store');
        Route::get('/{asset}/edit',  [AssetController::class, 'edit'])  ->name('edit');
        Route::patch('/{asset}',     [AssetController::class, 'update'])->name('update');
        Route::delete('/{asset}',    [AssetController::class, 'destroy'])->name('destroy');
    });

    // People
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/',              [MemberController::class, 'index']) ->name('index');
        Route::get('/create',        [MemberController::class, 'create'])->name('create');
        Route::post('/',             [MemberController::class, 'store']) ->name('store');
        Route::get('/{member}',      [MemberController::class, 'show'])  ->name('show');
        Route::get('/{member}/edit', [MemberController::class, 'edit'])  ->name('edit');
        Route::patch('/{member}',    [MemberController::class, 'update'])->name('update');
        Route::delete('/{member}',   [MemberController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('families')->name('families.')->group(function () {
        Route::get('/',              [FamilyController::class, 'index']) ->name('index');
        Route::get('/create',        [FamilyController::class, 'create'])->name('create');
        Route::post('/',             [FamilyController::class, 'store']) ->name('store');
        Route::get('/{family}',      [FamilyController::class, 'show'])  ->name('show');
        Route::get('/{family}/edit', [FamilyController::class, 'edit'])  ->name('edit');
        Route::patch('/{family}',    [FamilyController::class, 'update'])->name('update');
        Route::delete('/{family}',   [FamilyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/',             [GroupController::class, 'index']) ->name('index');
        Route::get('/create',       [GroupController::class, 'create'])->name('create');
        Route::post('/',            [GroupController::class, 'store']) ->name('store');
        Route::get('/{group}',      [GroupController::class, 'show'])  ->name('show');
        Route::get('/{group}/edit', [GroupController::class, 'edit'])  ->name('edit');
        Route::patch('/{group}',    [GroupController::class, 'update'])->name('update');
        Route::delete('/{group}',   [GroupController::class, 'destroy'])->name('destroy');
    });

    // Ministry
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/',             [EventController::class, 'index']) ->name('index');
        Route::get('/create',       [EventController::class, 'create'])->name('create');
        Route::post('/',            [EventController::class, 'store']) ->name('store');
        Route::get('/{event}',      [EventController::class, 'show'])  ->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])  ->name('edit');
        Route::patch('/{event}',    [EventController::class, 'update'])->name('update');
        Route::delete('/{event}',   [EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/approve', [EventController::class, 'approve'])->name('approve');
    });

    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/',                    [AttendanceController::class, 'index'])   ->name('index');
        Route::get('/create',              [AttendanceController::class, 'create'])  ->name('create');
        Route::post('/',                   [AttendanceController::class, 'store'])   ->name('store');
        Route::post('/bulk',               [AttendanceController::class, 'bulkStore'])->name('bulk');
        Route::post('/{attendance}/archive',[AttendanceController::class, 'archive'])->name('archive');
        Route::get('/archived',            [AttendanceController::class, 'archived'])->name('archived');
        Route::post('/restore/{id}',       [AttendanceController::class, 'restore']) ->name('restore');
    });

    Route::get('/sermons',                   [SermonController::class, 'adminIndex'])->name('sermons.index');
    Route::post('/sermons',                  [SermonController::class, 'store'])     ->name('sermons.store');
    Route::post('/sermons/{sermon}/approve', [SermonController::class, 'approve'])   ->name('sermons.approve');
    Route::delete('/sermons/{sermon}',       [SermonController::class, 'destroy'])   ->name('sermons.destroy');

    Route::get('/volunteering',  [VolunteerController::class, 'adminIndex'])->name('volunteering.index');
    Route::post('/volunteering', [VolunteerController::class, 'store'])     ->name('volunteering.store');

    Route::get('/check-in',  [ChildCheckInController::class, 'kiosk'])  ->name('checkin.kiosk');
    Route::post('/check-in/process', [ChildCheckInController::class, 'process'])->name('checkin.process');

    Route::get('/search', [SearchController::class, 'globalSearch'])->name('search');

    // Profile (Admin)
    Route::get('/profile',    [ProfileController::class, 'edit'])          ->name('profile.edit');
    Route::match(['patch', 'put'], '/profile',  [ProfileController::class, 'update'])        ->name('profile.update');
    Route::match(['patch', 'put'], '/profile/password',[ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
|*/
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // People
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/',              [StaffMemberController::class, 'index']) ->name('index');
        Route::get('/create',        [StaffMemberController::class, 'create'])->name('create');
        Route::post('/',             [StaffMemberController::class, 'store']) ->name('store');
        Route::get('/{member}',      [StaffMemberController::class, 'show'])  ->name('show');
    });

    Route::prefix('families')->name('families.')->group(function () {
        Route::get('/',              [StaffFamilyController::class, 'index']) ->name('index');
        Route::get('/create',        [StaffFamilyController::class, 'create'])->name('create');
        Route::post('/',             [StaffFamilyController::class, 'store']) ->name('store');
        Route::get('/{family}',      [StaffFamilyController::class, 'show'])  ->name('show');
    });

    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/',             [StaffGroupController::class, 'index']) ->name('index');
        Route::get('/create',       [StaffGroupController::class, 'create'])->name('create');
        Route::post('/',            [StaffGroupController::class, 'store']) ->name('store');
        Route::get('/{group}',      [StaffGroupController::class, 'show'])  ->name('show');
    });

    // Ministry
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/',             [StaffEventController::class, 'index']) ->name('index');
        Route::get('/create',       [StaffEventController::class, 'create'])->name('create');
        Route::post('/',            [StaffEventController::class, 'store']) ->name('store');
        Route::get('/{event}',      [StaffEventController::class, 'show'])  ->name('show');
        Route::get('/{event}/edit', [StaffEventController::class, 'edit'])  ->name('edit');
        Route::patch('/{event}',    [StaffEventController::class, 'update'])->name('update');
    });

    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/',                    [StaffAttendanceController::class, 'index'])   ->name('index');
        Route::get('/create',              [StaffAttendanceController::class, 'create'])  ->name('create');
        Route::post('/',                   [StaffAttendanceController::class, 'store'])   ->name('store');
        Route::post('/bulk',               [StaffAttendanceController::class, 'bulkStore'])->name('bulk');
    });

    Route::get('/sermons',  [StaffSermonController::class, 'index'])->name('sermons.index');
    Route::post('/sermons', [StaffSermonController::class, 'store'])->name('sermons.store');

    Route::get('/volunteering',  [StaffVolunteerController::class, 'index'])->name('volunteering.index');
    Route::post('/volunteering', [StaffVolunteerController::class, 'store'])->name('volunteering.store');

    Route::get('/check-in',  [StaffCheckInController::class, 'kiosk'])  ->name('checkin.kiosk');
    Route::post('/check-in/process', [StaffCheckInController::class, 'process'])->name('checkin.process');

    // Profile (Staff)
    Route::get('/profile',    [ProfileController::class, 'edit'])          ->name('profile.edit');
    Route::match(['patch', 'put'], '/profile',  [ProfileController::class, 'update'])        ->name('profile.update');
    Route::match(['patch', 'put'], '/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',  [MemberProfileController::class, 'index']) ->name('profile');
    Route::post('/profile', [MemberProfileController::class, 'update'])->name('profile.update');

    // Attendance (read-only for member)
    Route::get('/attendance', [MemberAttendanceController::class, 'index'])->name('attendance');

    // Events
    Route::get('/events',                      [MemberEventsController::class, 'index'])           ->name('events');
    Route::post('/events/{event}/join',        [MemberEventsController::class, 'register'])         ->name('events.join');
    Route::post('/events/{event}/cancel',      [MemberEventsController::class, 'cancelRegistration'])->name('events.cancel');
    Route::post('/events/{event}/check-in',    [MemberEventsController::class, 'checkIn'])          ->name('events.checkin');
    Route::post('/events/{event}/check-out',   [MemberEventsController::class, 'checkOut'])         ->name('events.checkout');

    // Groups
    Route::get('/groups',               [MemberGroupsController::class, 'index'])->name('groups');
    Route::post('/groups/{group}/join', [MemberGroupsController::class, 'join']) ->name('groups.join');
    Route::post('/groups/{group}/leave',[MemberGroupsController::class, 'leave'])->name('groups.leave');

    // Family
    Route::get('/family', [MemberFamilyController::class, 'index'])->name('family');

    // Donations (includes Give Online section)
    Route::get('/donations',                          [MemberDonationController::class, 'index'])  ->name('donations');
    Route::post('/donations',                         [MemberDonationController::class, 'store'])  ->name('donations.store');
    Route::get('/donations/{donation}/receipt',       [MemberDonationController::class, 'receipt'])->name('donations.receipt');
});

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes (all roles: admin, staff, member)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Sermon Library
    Route::get('/sermons',         [SermonController::class, 'index'])->name('sermons.index');
    Route::get('/sermons/{sermon}', [SermonController::class, 'show'])->name('sermons.show');

    // My Children
    Route::get('/children',  [ChildCheckInController::class, 'index'])     ->name('member.children.index');
    Route::post('/children', [ChildCheckInController::class, 'storeChild'])->name('member.children.store');

    // Volunteering
    Route::get('/volunteering',                            [VolunteerController::class, 'index']) ->name('member.volunteering.index');
    Route::post('/volunteering/{opportunity}/signup',      [VolunteerController::class, 'signup'])->name('member.volunteering.signup');

    // Messaging (Shared)
    Route::get('/messages',           [MessagesController::class, 'index']) ->name('messages.index');
    Route::get('/messages/create',    [MessagesController::class, 'create'])->name('messages.create');
    Route::post('/messages',          [MessagesController::class, 'store']) ->name('messages.store');
    Route::get('/messages/{message}', [MessagesController::class, 'show'])  ->name('messages.show');
});

