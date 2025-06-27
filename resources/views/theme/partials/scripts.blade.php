<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Vendor JS Files -->
<script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/vendor/php-email-form/validate.js"></script>
<script src="{{ asset('assets') }}/vendor/aos/aos.js"></script>
<script src="{{ asset('assets') }}/vendor/glightbox/js/glightbox.min.js"></script>
<script src="{{ asset('assets') }}/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="{{ asset('assets') }}/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="{{ asset('assets') }}/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Sweet alert --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.invitation-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // prevent actual form submit

                const userName = form.getAttribute('data-username');
                const formData = new FormData(form);
                const csrfToken = formData.get('_token');

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: `هل تريد إرسال دعوة إلى ${userName}؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، أرسل الدعوة',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('invitations.send') }}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('حدث خطأ في الإرسال');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    title: 'تم الإرسال!',
                                    text: 'تم إرسال الدعوة بنجاح.',
                                    icon: 'success',
                                    confirmButtonText: 'حسناً'
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'خطأ!',
                                    text: error.message,
                                    icon: 'error',
                                    confirmButtonText: 'حسناً'
                                });
                            });
                    }
                });
            });
        });
    });
</script>

{{-- Invitation Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Invitation script loaded');

        // Handle invitation button clicks
        $(document).on('click', '.send-invitation-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const userName = form.data('user-name') || 'هذا المستخدم';
            const btn = $(this);

            // Force correct form action
            form.attr('action', '{{ route('invitations.send') }}');
            console.log('Form action set to:', form.attr('action'));

            // Show loading state
            btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" role="status"></span>
                جاري التحقق...
            `);

            // Check eligibility first
            checkInvitationEligibility()
                .then(response => {
                    console.log('Eligibility check response:', response);
                    btn.prop('disabled', false).text('دعوة');

                    if (response.status === 'unauthenticated') {
                        showError('يجب تسجيل الدخول أولاً لإرسال دعوات');
                    } else if (response.status === 'incomplete') {
                        showProfileIncompleteWarning(response.completion_percentage);
                    } else {
                        // Show confirmation dialog
                        Swal.fire({
                            title: 'إرسال دعوة',
                            html: `هل تريد إرسال دعوة إلى <strong>${userName}</strong>؟`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'نعم، أرسل الدعوة',
                            cancelButtonText: 'إلغاء',
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#d33',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log('Sending invitation to:', userName);
                                sendInvitation(form);
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Eligibility check error:', error);
                    btn.prop('disabled', false).text('دعوة');
                    showError('حدث خطأ أثناء التحقق من الأهلية');
                });
        });

        // Check eligibility function
        function checkInvitationEligibility() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route('invitations.check') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Eligibility check failed:', status, error);
                        reject(error);
                    }
                });
            });
        }

        // Show error message
        function showError(message) {
            Swal.fire({
                title: 'خطأ',
                text: message,
                icon: 'error',
                confirmButtonColor: '#4e73df',
                confirmButtonText: 'حسناً'
            });
        }

        // Show profile incomplete warning
        function showProfileIncompleteWarning(percentage) {
            Swal.fire({
                title: 'ملف غير مكتمل',
                html: `يجب إكمال ملفك الشخصي بنسبة 100% قبل إرسال الدعوات.<br>
                      <small>إكتمال الملف الحالي: ${percentage}%</small><br>
                      <a href="{{ route('myProfile') }}" class="btn btn-primary mt-2">الذهاب إلى الملف الشخصي</a>`,
                icon: 'warning',
                confirmButtonColor: '#4e73df'
            });
        }

        // Send invitation request
        function sendInvitation(form) {
            const btn = form.find('button');
            btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" role="status"></span>
                جاري الإرسال...
            `);

            const requestData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                destination_user_id: form.find('input[name="destination_user_id"]').val()
            };

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: requestData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    btn.prop('disabled', false).text('دعوة مرسلة');
                    Swal.fire({
                        title: 'تم بنجاح',
                        text: response.message || 'تم إرسال الدعوة بنجاح!',
                        icon: 'success',
                        confirmButtonColor: '#4e73df',
                        confirmButtonText: 'حسناً'
                    });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('دعوة');
                    let errorMessage = 'حدث خطأ أثناء إرسال الدعوة';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showError(errorMessage);
                }
            });
        }
    });
</script>

{{-- Invitation Reply Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Invitation reply script loaded');

        // Handle reply button clicks
        $(document).on('click', '.reply-btn', function() {
            const button = $(this);
            const url = button.data('url');
            const reply = button.data('reply');

            Swal.fire({
                title: 'تأكيد الرد',
                text: `هل أنت متأكد من ${reply} الدعوة؟`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `نعم، ${reply}`,
                cancelButtonText: 'إلغاء',
                confirmButtonColor: reply === 'قبول' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    sendReply(url, reply, button);
                }
            });
        });

        // Function to send the reply
        function sendReply(url, reply, button) {
            const originalText = button.text();
            button.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" role="status"></span>
                جاري الإرسال...
            `);

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    reply: reply
                },
                success: function(response) {
                    Swal.fire({
                        title: 'تم بنجاح',
                        text: response.message || 'تم تحديث حالة الدعوة',
                        icon: 'success',
                        confirmButtonText: 'حسناً'
                    }).then(() => {
                        location.reload(); // Refresh to show updated status
                    });
                },
                error: function(xhr) {
                    button.prop('disabled', false).text(originalText);
                    let errorMessage = 'حدث خطأ أثناء إرسال الرد';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'خطأ',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'حسناً'
                    });
                }
            });
        }
    });
</script>

<script>
    function validateInvitationEligibility() {
        fetch('{{ route('invitations.check') }}')
            .then(response => {
                if (!response.ok) throw response;
                return response.json();
            })
            .then(data => {
                // User is authenticated and complete
                window.location.href = '{{ route('invitations.index') }}';
            })
            .catch(async error => {
                if (error.status === 401) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'غير مسجل',
                        text: 'يرجى تسجيل الدخول أولاً.',
                        confirmButtonText: 'تسجيل الدخول'
                    }).then(() => {
                        window.location.href = '{{ route('login') }}';
                    });
                } else if (error.status === 403) {
                    Swal.fire({
                        icon: 'info',
                        title: 'الملف الشخصي غير مكتمل',
                        text: 'يرجى إكمال معلوماتك الشخصية قبل إرسال دعوة.',
                        confirmButtonText: 'إكمال الملف'
                    }).then(() => {
                        window.location.href = '{{ route('myProfile') }}';
                    });
                }
            });
    }
</script>

{{-- Skills filtrations --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');

        // Function to handle form submission
        function submitForm() {
            const formData = new FormData(filterForm);
            const url = new URL(window.location.href);

            // Show loading indicator
            document.getElementById('users-container').innerHTML =
                '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">جار التحميل...</span></div></div>';

            fetch(url.pathname + '?' + new URLSearchParams(formData), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('users-container').innerHTML = data.html;
                    document.getElementById('pagination-links').innerHTML = data.pagination;

                    // Reinitialize any necessary JS for the new content
                    initializeInvitationForms();
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('users-container').innerHTML =
                        '<div class="col-12 text-center py-5"><h4>حدث خطأ أثناء جلب البيانات</h4></div>';
                });
        }

        // Handle form changes
        filterForm.querySelectorAll('input[type="checkbox"], select[name="sort"], input[name="search"]')
            .forEach(element => {
                element.addEventListener('change', function() {
                    submitForm();
                });
            });

        // Handle search input with debounce
        const searchInput = filterForm.querySelector('input[name="search"]');
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                submitForm();
            }, 500);
        });

        // Handle pagination clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = e.target.closest('a').href;

                // Show loading indicator
                document.getElementById('users-container').innerHTML =
                    '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">جار التحميل...</span></div></div>';

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('users-container').innerHTML = data.html;
                        document.getElementById('pagination-links').innerHTML = data.pagination;

                        // Update URL without reload
                        window.history.pushState({}, '', url);

                        // Reinitialize any necessary JS for the new content
                        initializeInvitationForms();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('users-container').innerHTML =
                            '<div class="col-12 text-center py-5"><h4>حدث خطأ أثناء جلب البيانات</h4></div>';
                    });
            }
        });

        // Function to reinitialize invitation forms
        function initializeInvitationForms() {
            document.querySelectorAll('.invitation-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const userName = form.getAttribute('data-username');
                    const formData = new FormData(form);
                    const csrfToken = formData.get('_token');

                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: `هل تريد إرسال دعوة إلى ${userName}؟`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، أرسل الدعوة',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ route('invitations.send') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: formData
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('حدث خطأ في الإرسال');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire({
                                        title: 'تم الإرسال!',
                                        text: 'تم إرسال الدعوة بنجاح.',
                                        icon: 'success',
                                        confirmButtonText: 'حسناً'
                                    });
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: 'خطأ!',
                                        text: error.message,
                                        icon: 'error',
                                        confirmButtonText: 'حسناً'
                                    });
                                });
                        }
                    });
                });
            });
        }
    });
</script>

{{-- Skills Pagination + Invitation Init --}}
<script>
    // Global invitation initialization function
    function initializeInvitationForms() {
        // Remove old listeners to prevent duplication
        document.querySelectorAll('.invite-btn').forEach(btn => {
            btn.removeEventListener('click', handleInviteClick); // detach if already exists
            btn.addEventListener('click', handleInviteClick); // attach fresh
        });
    }

    // Define the actual event handler
    function handleInviteClick(e) {
        const userId = e.currentTarget.getAttribute('data-user-id');
        console.log('Invitation clicked for user:', userId);

        // You can replace this with actual logic (e.g., show modal, send AJAX)
        alert('دعوة المستخدم رقم: ' + userId);
    }

    // Run once on initial page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeInvitationForms();
    });

    // Handle AJAX pagination
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            const url = link.getAttribute('href');

            document.getElementById('users-container').innerHTML =
                '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">جار التحميل...</span></div></div>';

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('users-container').innerHTML = data.html;
                    document.getElementById('pagination-links').innerHTML = data.pagination;

                    // Reinitialize functionality on new elements
                    initializeInvitationForms();
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('users-container').innerHTML =
                        '<div class="col-12 text-center py-5"><h4>حدث خطأ أثناء جلب البيانات</h4></div>';
                });
        }
    });
</script>


{{-- Contact us --}}
<script>
    $(document).ready(function() {
        // Handle form submission
        $('form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);

            // Show loading state
            form.find('button[type="submit"]').prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                جاري الإرسال...
            `);

            // Submit form via AJAX
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // If form was submitted with AJAX (optional)
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    // Handle errors if using AJAX
                    form.find('button[type="submit"]').prop('disabled', false).text(
                        'إرسال');
                    alert('حدث خطأ أثناء إرسال النموذج. يرجى المحاولة مرة أخرى.');
                }
            });
        });
    });
</script>
