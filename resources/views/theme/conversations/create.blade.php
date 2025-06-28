@extends('theme.master')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">بدء محادثة جديدة</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">اختر شخصاً للدردشة معه:</h5>

                <div class="list-group">
                    @foreach ($invitations as $invitation)
                        @php $user = $invitation->sourceUser; @endphp
                        @if (!$user)
                            @continue
                        @endif

                        <form action="{{ route('conversations.store') }}" method="POST" class="conversation-form mb-3"
                            data-user-id="{{ $user->id }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="list-group-item d-flex align-items-start">
                                <img src="{{ $user->image_url }}" class="rounded-circle me-3" width="50" height="50"
                                    alt="{{ $user->fullName() }}">

                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $user->fullName() }}</h6>
                                    <small class="text-muted">قبلت دعوتك في
                                        {{ $invitation->updated_at->diffForHumans() }}</small>

                                    <textarea name="message" class="form-control mt-2" rows="2" placeholder="اكتب رسالتك هنا..." required></textarea>

                                    <button type="submit" class="btn btn-primary btn-sm mt-2 send-message-btn">
                                        <span class="btn-text">إرسال</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                    <div class="error-message text-danger small mt-1 d-none"></div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .conversation-form .error-message {
            min-height: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.conversation-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // 🚨 Critical: prevent full POST

                    const submitBtn = form.querySelector('.send-message-btn');
                    const spinner = submitBtn.querySelector('.spinner-border');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const errorMessage = form.querySelector('.error-message');

                    // Reset UI
                    errorMessage.classList.add('d-none');
                    errorMessage.textContent = '';
                    submitBtn.disabled = true;
                    btnText.textContent = 'جاري الإرسال...';
                    spinner.classList.remove('d-none');

                    fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.error ||
                                        'حدث خطأ أثناء الإرسال');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success && data.redirect) {
                                Swal.fire({
                                    title: 'تم إرسال الرسالة!',
                                    text: 'سيتم تحويلك إلى المحادثة الآن.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 2000);
                            } else if (data.error) {
                                throw new Error(data.error);
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            errorMessage.textContent = error.message;
                            errorMessage.classList.remove('d-none');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            btnText.textContent = 'إرسال';
                            spinner.classList.add('d-none');
                        });
                });
            });
        });
    </script>
@endpush




{{-- @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.conversation-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = form.querySelector('.send-message-btn');
                    const spinner = submitBtn.querySelector('.spinner-border');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const errorMessage = form.querySelector('.error-message');

                    // Reset UI
                    errorMessage.classList.add('d-none');
                    errorMessage.textContent = '';
                    submitBtn.disabled = true;
                    btnText.textContent = 'جاري الإرسال...';
                    spinner.classList.remove('d-none');

                    fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.error || 'خطأ في الاستجابة');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success && data.redirect) {
                                Swal.fire({
                                    title: 'تم الإرسال!',
                                    text: 'تم بدء المحادثة بنجاح',
                                    icon: 'success',
                                    confirmButtonText: 'حسناً',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 2000);
                            } else if (data.error) {
                                throw new Error(data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            errorMessage.textContent = error.message;
                            errorMessage.classList.remove('d-none');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            btnText.textContent = 'إرسال';
                            spinner.classList.add('d-none');
                        });
                });
            });
        });
    </script>
@endpush --}}
