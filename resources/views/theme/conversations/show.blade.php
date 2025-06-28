@extends('theme.master')

@section('content')
    <div class="container-fluid conversations-container py-3">
        <div class="row gx-4">
            <!-- Sidebar -->
            <div class="col-md-4 col-lg-3 sidebar">
                <div class="card shadow-sm h-100 d-flex flex-column">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">المحادثات</h5>
                    </div>
                    <div class="card-body p-0 overflow-auto flex-grow-1">
                        <div class="list-group list-group-flush">
                            @foreach (auth()->user()->conversations as $conv)
                                @php
                                    $otherUserSidebar = $conv->users->where('id', '!=', auth()->id())->first();
                                @endphp
                                <a href="{{ route('conversations.show', $conv) }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center
                                    {{ $conv->id == $conversation->id ? 'active bg-primary text-white' : '' }}">
                                    <img src="{{ $otherUserSidebar->image_url }}" class="rounded-circle me-3" width="45"
                                        height="45" alt="{{ $otherUserSidebar->fullName() }}">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $otherUserSidebar->fullName() }}</h6>
                                        <small
                                            class="{{ $conv->id == $conversation->id ? 'text-white-50' : 'text-muted' }} text-truncate d-block"
                                            style="max-width: 160px;">
                                            {{ $conv->messages->first()?->body ?? 'لا توجد رسائل' }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8 col-lg-9 main-content d-flex flex-column">
                <div class="card shadow-sm flex-grow-1 d-flex flex-column">
                    <!-- Conversation Header -->
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $otherUser->image_url }}" class="rounded-circle me-3" width="50" height="50"
                                alt="{{ $otherUser->fullName() }}">
                            <h5 class="mb-0">{{ $otherUser->fullName() }}</h5>
                        </div>
                        {{-- <button class="btn btn-outline-danger btn-sm leave-conversation"
                            data-url="{{ route('conversations.leave', $conversation) }}">
                            مغادرة المحادثة
                        </button> --}}
                    </div>

                    <!-- Messages -->
                    <div class="card-body messages-container flex-grow-1 overflow-auto bg-white px-3 py-2" id="messages">
                        @foreach ($messages as $message)
                            <div
                                class="message d-flex {{ $message->user_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                                <div class="message-content p-3 rounded shadow
                                    {{ $message->user_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}"
                                    style="max-width: 75%; word-wrap: break-word;">
                                    <p class="mb-1">{{ $message->body }}</p>
                                    <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                                        {{ $message->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Form -->
                    <div class="card-footer bg-light">
                        <form id="messageForm" action="{{ route('conversations.messages.store', $conversation) }}"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="body" id="messageInput" class="form-control"
                                    placeholder="اكتب رسالة..." required autocomplete="off">
                                <button class="btn btn-primary" type="submit" id="sendBtn">إرسال</button>
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
        html,
        body {
            height: 100%;
            background-color: #f8f9fa;
        }

        .conversations-container {
            height: calc(100vh - 100px);
        }

        .sidebar {
            height: 100%;
            border-radius: 0.5rem;
        }

        .main-content {
            height: 100%;
        }

        .messages-container {
            background-color: #fff;
            height: 100%;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .message-content {
            font-size: 0.95rem;
            line-height: 1.3;
            word-break: break-word;
            position: relative;
        }

        .message.sent .message-content {
            background-color: #0d6efd;
            color: #fff;
        }

        .message.received .message-content {
            background-color: #e9ecef;
            color: #212529;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 0.25rem;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s ease;
            user-select: none;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #ffc107;
        }

        /* Scrollbar styling */
        .messages-container::-webkit-scrollbar {
            width: 8px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .messages-container::-webkit-scrollbar-track {
            background-color: transparent;
        }

        /* Sidebar active conversation styling */
        .list-group-item.active {
            font-weight: 600;
            border-color: #0d6efd;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            const messagesContainer = $('#messages');
            const messageForm = $('#messageForm');
            const messageInput = $('#messageInput');
            const sendBtn = $('#sendBtn');

            // Scroll to bottom on initial load
            scrollToBottom();

            // AJAX message sending
            messageForm.on('submit', function(e) {
                e.preventDefault();

                const message = messageInput.val().trim();
                if (!message) return;

                sendBtn.prop('disabled', true);

                $.ajax({
                    url: messageForm.attr('action'),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        body: message,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Create and append new message
                            const newMessage = createMessageElement(response.message, true);
                            messagesContainer.append(newMessage);
                            scrollToBottom();
                            messageInput.val('');

                            // Optionally: Update the sidebar preview
                            updateSidebarPreview(response.message.conversation_id, message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to send message. Please try again.',
                            icon: 'error'
                        });
                    },
                    complete: function() {
                        sendBtn.prop('disabled', false);
                    }
                });
            });

            // Function to scroll to bottom
            function scrollToBottom() {
                messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
            }

            // Function to create message HTML element
            function createMessageElement(message, isSent) {
                const now = new Date();
                const timeString = now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                return `
                <div class="message d-flex ${isSent ? 'justify-content-end' : 'justify-content-start'} mb-2">
                    <div class="message-content p-3 rounded shadow 
                        ${isSent ? 'bg-primary text-white' : 'bg-light text-dark'}" 
                        style="max-width: 75%; word-wrap: break-word;">
                        <p class="mb-1">${escapeHtml(message.body)}</p>
                        <small class="${isSent ? 'text-white-50' : 'text-muted'} fst-italic" style="font-size: 0.75rem;">
                            ${timeString}
                        </small>
                    </div>
                </div>
            `;
            }

            function updateSidebarPreview(conversationId, messageText) {
                $(`a[href*="/conversations/${conversationId}"] small`).text(messageText);
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            let loading = false;
            messagesContainer.on('scroll', function() {
                if (messagesContainer.scrollTop() === 0 && !loading) {
                    loading = true;
                    const firstMessage = $('.message').first();
                    const firstMessageId = firstMessage.data('id');

                    $.ajax({
                        url: '{{ route('conversations.show', $conversation) }}',
                        data: {
                            before: firstMessageId,
                            _ajax: true
                        },
                        success: function(response) {
                            if (response.html) {
                                const scrollPosition = messagesContainer.scrollTop();
                                const scrollHeight = messagesContainer[0].scrollHeight;

                                $(response.html).insertBefore(firstMessage);

                                messagesContainer.scrollTop(messagesContainer[0].scrollHeight -
                                    scrollHeight + scrollPosition);
                            }
                        },
                        complete: function() {
                            loading = false;
                        }
                    });
                }
            });
        });
    </script>
@endpush
