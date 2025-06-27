@extends('theme.master')

@section('content')
    <div class="container-fluid conversations-container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-4 col-lg-3 sidebar">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">المحادثات</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach (auth()->user()->conversations as $conv)
                                <a href="{{ route('conversations.show', $conv) }}"
                                    class="list-group-item list-group-item-action {{ $conv->id == $conversation->id ? 'active' : '' }}">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $otherUser = $conv->users->where('id', '!=', auth()->id())->first();
                                        @endphp
                                        <img src="{{ $otherUser->image_url }}" class="rounded-circle me-3" width="40"
                                            height="40" alt="{{ $otherUser->fullName() }}">
                                        <div>
                                            <h6 class="mb-0">{{ $otherUser->fullName() }}</h6>
                                            <small
                                                class="{{ $conv->id == $conversation->id ? 'text-white' : 'text-muted' }}">
                                                {{ $conv->messages->first()->body ?? 'لا توجد رسائل' }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8 col-lg-9 main-content">
                <div class="card shadow-sm h-100">
                    <!-- Conversation Header -->
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $otherUser->image_url }}" class="rounded-circle me-3" width="40" height="40"
                                alt="{{ $otherUser->fullName() }}">
                            <h5 class="mb-0">{{ $otherUser->fullName() }}</h5>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-danger leave-conversation"
                                data-url="{{ route('conversations.leave', $conversation) }}">
                                مغادرة المحادثة
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="card-body messages-container">
                        <div class="messages" id="messages">
                            @foreach ($messages as $message)
                                <div class="message {{ $message->user_id == auth()->id() ? 'sent' : 'received' }}">
                                    <div class="message-content">
                                        <p>{{ $message->body }}</p>
                                        <small class="text-muted">
                                            {{ $message->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Message Form -->
                    <div class="card-footer bg-light">
                        <form action="{{ route('conversations.messages.store', $conversation) }}" method="POST"
                            class="message-form">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="body" class="form-control" placeholder="اكتب رسالة..."
                                    required>
                                <button class="btn btn-primary" type="submit">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تقييم {{ $otherUser->fullName() }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('conversations.review.store', $conversation) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">التقييم</label>
                            <div class="rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating"
                                        value="{{ $i }}" required>
                                    <label for="star{{ $i }}">★</label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تعليق (اختياري)</label>
                            <textarea name="comment" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .conversations-container {
            height: calc(100vh - 150px);
        }

        .sidebar,
        .main-content {
            height: 100%;
        }

        .messages-container {
            overflow-y: auto;
            height: calc(100% - 120px);
        }

        .messages {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
        }

        .message.sent {
            align-self: flex-end;
            background-color: #007bff;
            color: white;
        }

        .message.received {
            align-self: flex-start;
            background-color: #f1f1f1;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked~label {
            color: #ffc107;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #ffc107;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-scroll to bottom of messages
            const messagesContainer = $('#messages');
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);

            // Handle leave conversation
            $('.leave-conversation').click(function() {
                const url = $(this).data('url');

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: 'سيتم مغادرة هذه المحادثة ولن تتمكن من إرسال رسائل جديدة',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، مغادرة',
                    cancelButtonText: 'إلغاء',
                    confirmButtonColor: '#dc3545',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                window.location.href =
                                    '{{ route('conversations.index') }}';
                            }
                        });
                    }
                });
            });

            // Show review modal when leaving conversation
            $('#leaveConversation').click(function() {
                $('#reviewModal').modal('show');
            });

            // Real-time messaging with Pusher (example)
            // You'll need to implement this based on your real-time solution
            // Echo.private(`conversation.${conversationId}`)
            //     .listen('MessageSent', (e) => {
            //         // Append new message to the chat
            //     });
        });
    </script>
@endpush
