<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\User;

class InvitationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $invitations = Invitation::with('sourceUser')
            ->where('destination_user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('theme.invitations', compact('invitations'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'destination_user_id' => 'required|exists:users,id',
        ]);

        $sourceUser = auth()->user();
        $destinationUserId = $request->destination_user_id;

        // Prevent sending invite to self or duplicate invites
        if ($sourceUser->id == $destinationUserId) {
            return back()->with('error', 'لا يمكنك دعوة نفسك.');
        }

        $exists = Invitation::where('source_user_id', $sourceUser->id)
            ->where('destination_user_id', $destinationUserId)
            ->whereNull('reply')
            ->exists();

        if ($exists) {
            return back()->with('info', 'لقد أرسلت دعوة بالفعل لهذا المستخدم.');
        }

        Invitation::create([
            'source_user_id' => $sourceUser->id,
            'destination_user_id' => $destinationUserId,
            'date_time' => now(),
        ]);

        // return back()->with('success', 'تم إرسال الدعوة بنجاح!');
        return response()->json(['status' => 'success']);
    }

    public function reply(Request $request, Invitation $invitation)
    {
        \Log::info('Reply request', $request->all());

        $request->validate([
            'reply' => 'required|in:قبول,رفض',
        ]);

        if ($invitation->destination_user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بالرد على هذه الدعوة.');
        }

        $invitation->update([
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'تم تحديث حالة الدعوة.');
    }

    public function checkEligibility()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        if ($user->profileCompletionPercentage() < 100) {
            return response()->json(['status' => 'incomplete'], 403);
        }

        return response()->json(['status' => 'ok']);
    }
}
