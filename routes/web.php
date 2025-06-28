<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
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
    Route::put('/profile/qualifications', [ProfileController::class, 'updateQualifications'])
        ->name('profile.update-qualifications');

    // ================= Invitation ===============
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    // Route::post('/invitations/send', [InvitationController::class, 'send'])->name('invitations.send');

    Route::post('/invitations/send', [InvitationController::class, 'send'])
        ->name('invitations.send');

    Route::post('/invitations/{invitation}/reply', [InvitationController::class, 'reply'])->name('invitations.reply');

    Route::get('/invitation/check-eligibility', [InvitationController::class, 'checkEligibility'])
        ->name('invitations.check');

    // ================= Notifications for invitations =====================
    Route::post('/onesignal/update', function (\Illuminate\Http\Request $request) {
        $user = \App\Models\User::findOrFail(auth()->id());
        $user->update(['onesignal_player_id' => $request->player_id]);

        return response()->json(['message' => 'Player ID updated']);
    })->name('onesignal.update')->middleware('auth');

    Route::get('/invitations/count', function () {
        $count = \App\Models\Invitation::where('destination_user_id', auth()->id())
            ->whereNull('reply')->count();

        return response()->json(['count' => $count]);
    })->middleware('auth');

    // ================ Conversations ===============
    Route::prefix('conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/create', [ConversationController::class, 'create'])->name('create');
        Route::post('/', [ConversationController::class, 'store'])->name('store');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
        Route::post('/{conversation}/messages', [ConversationController::class, 'storeMessage'])->name('messages.store');
        Route::post('/{conversation}/leave', [ConversationController::class, 'leave'])->name('leave');
        Route::post('/{conversation}/review', [ConversationController::class, 'storeReview'])->name('review.store');
    });
});


Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');



require __DIR__ . '/auth.php';
