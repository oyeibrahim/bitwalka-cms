<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Test;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


// ----------------------
// Sending mail with Mail and Notification class
// ----------------------
//
// use App\Mail\TestMail;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Notification;
// use App\Notifications\TestNotification;
//
// ----------------------



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // You can use session or user setting to set initial locale here
    return redirect(app()->getLocale());
});

// ----------------------
// Admin Pages
// ----------------------
Route::get('/admin', [HomeController::class,'home'])->middleware(['admin']);

Route::get('/backend/admins/list', [UsersController::class,'admin_list'])->middleware(['admin']);
Route::get('/backend/editors/list', [UsersController::class,'editor_list'])->middleware(['admin']);

Route::get('/backend/users/list', [UsersController::class,'list'])->middleware(['admin']);

Route::get('/backend/users/user/{id}', [UsersController::class,'user'])->middleware(['admin']);
Route::get('/backend/users/edit/{id}', [UsersController::class,'edit'])->middleware(['admin']);
Route::post('/backend/users/update', [UsersController::class,'editController'])->middleware(['admin']);
// 
// ----------------------


// ----------------------
// Editor Pages
// ----------------------
Route::get('/editor', function () {
    echo "EDITOR Page";
})->middleware(['editor']);
// 
// ----------------------


Route::group(
    [
        'prefix' => '{locale}',
        'middleware' => 'setlocale'
    ],
    function () {

        Route::get('/', function () {
            // ----------------------
            // Sending mail with Mail and Notification class
            // ----------------------
            //
            // $name = 'This is a Test';
            // Mail::to('f6513f231a-6bc8be@inbox.mailtrap.io')->send(new TestMail($name));
            // Notification::route('mail', 'f6513f231a-6bc8be@inbox.mailtrap.io')->notify(new TestNotification($name));
            //
            // ----------------------
            return view('welcome');
        });

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/image-update', [AvatarController::class, 'update'])->name('image.update');
        });

        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice');


        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();

            return redirect('/home');
        })->middleware(['auth', 'signed'])->name('verification.verify');


        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('message', 'Verification link sent!');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

        Route::get('/test', [Test::class, 'index']);


        require __DIR__ . '/auth.php';
    }
);


