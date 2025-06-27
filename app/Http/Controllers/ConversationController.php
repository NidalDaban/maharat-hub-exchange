<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\ChatMessageSent;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['users', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->wherePivot('is_active', true)
            ->orderByDesc('last_message_at')
            ->paginate(10);

        return view('theme.conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $messages = $conversation->messages()
            ->with('user')
            ->latest()
            ->paginate(20);

        $otherUser = $conversation->users()->where('user_id', '!=', Auth::id())->first();

        return view('theme.conversations.show', compact('conversation', 'messages', 'otherUser'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id|not_in:' . auth()->id(),
                'message' => 'required|string|max:1000',
            ]);

            $targetUserId = $request->user_id;
            $currentUserId = auth()->id();

            // Check if invitation was accepted
            $acceptedInvitation = auth()->user()->receivedInvitations()
                ->where('source_user_id', $targetUserId)
                ->where('reply', 'قبول')
                ->exists();

            if (!$acceptedInvitation) {
                return response()->json([
                    'success' => false,
                    'error' => 'يجب قبول الدعوة أولاً قبل بدء المحادثة'
                ], 422);
            }

            // Check for existing conversation
            $existing = auth()->user()->conversations()
                ->whereHas('users', fn($q) => $q->where('user_id', $targetUserId))
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('conversations.show', $existing)
                ]);
            }

            DB::beginTransaction();

            // Create conversation
            $conversation = Conversation::create([
                'title' => 'New Conversation',
                'last_message_at' => now()
            ]);

            // Attach users with proper pivot data
            $conversation->users()->attach([
                $currentUserId => [
                    'body' => $request->message,
                    'is_active' => true,
                    'read_at' => now(),
                    'left_at' => null,
                ],
                $targetUserId => [
                    'body' => null,
                    'is_active' => true,
                    'read_at' => null,
                    'left_at' => null,
                ],
            ]);

            // Create initial message
            $message = $conversation->messages()->create([
                'user_id' => $currentUserId,
                'body' => $request->message,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('conversations.show', $conversation)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء إنشاء المحادثة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        $conversation->update(['last_message_at' => now()]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return back()->with('success', 'تم إرسال الرسالة');
    }

    public function leave(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        auth()->user()->conversations()->updateExistingPivot($conversation->id, [
            'is_active' => false,
            'left_at' => now()
        ]);

        return redirect()->route('conversations.index')
            ->with('success', 'تم مغادرة المحادثة');
    }

    public function storeReview(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        $otherUser = $conversation->users()->where('user_id', '!=', auth()->id())->first();

        Review::create([
            'sender_id' => auth()->id(),
            'receved_id' => $otherUser->id,
            'ratings' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'تم إرسال التقييم بنجاح');
    }

    public function create()
    {
        $userId = auth()->id();

        $invitations = auth()->user()->receivedInvitations()
            ->with('sourceUser')
            ->where('reply', 'قبول')
            ->get()
            ->filter(function ($invitation) use ($userId) {
                return !DB::table('conversations')
                    ->join('conversation_user as cu1', 'conversations.id', '=', 'cu1.conversation_id')
                    ->join('conversation_user as cu2', 'conversations.id', '=', 'cu2.conversation_id')
                    ->where('cu1.user_id', $userId)
                    ->where('cu2.user_id', $invitation->source_user_id)
                    ->exists();
            });

        return view('theme.conversations.create', ['invitations' => $invitations]);
    }
}
