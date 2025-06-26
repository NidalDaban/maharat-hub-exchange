<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/skills', 'skills')->name('skills');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/privacyPolicy', 'privacyPolicy')->name('privacyPolicy');
    Route::get('/termsOfServices', 'termsOfServices')->name('termsOfServices');
    Route::get('/profile/{user}', 'showProfile')->name('profile.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/myProfile', [ProfileController::class, 'myProfile'])->name('myProfile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload-image');
    Route::post('profile/remove-image', [ProfileController::class, 'removeImage'])->name('profile.remove-image');

    Route::get('/api/skills', [ProfileController::class, 'getSkills'])->name('api.skills');
    Route::get('/api/languages', [ProfileController::class, 'getLanguages'])->name('api.languages');

    // ================= Invitation ===============
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations/send', [InvitationController::class, 'send'])->name('invitations.send');
    Route::post('/invitations/{invitation}/reply', [InvitationController::class, 'reply'])->name('invitations.reply');

});

Route::get('/invitation/check-eligibility', [InvitationController::class, 'checkEligibility'])->name('invitations.check');


require __DIR__ . '/auth.php';
