<!-- Vendor JS Files -->
<script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/vendor/php-email-form/validate.js"></script>
<script src="{{ asset('assets') }}/vendor/aos/aos.js"></script>
<script src="{{ asset('assets') }}/vendor/glightbox/js/glightbox.min.js"></script>
<script src="{{ asset('assets') }}/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="{{ asset('assets') }}/vendor/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Main JS File -->
<script src="{{ asset('assets') }}/js/main.js"></script>


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

<script>
    function confirmReply(url, replyValue) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: `هل تريد ${replyValue} هذه الدعوة؟`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'نعم',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit a form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // CSRF token
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = csrfToken;

                // reply value
                const replyInput = document.createElement('input');
                replyInput.type = 'hidden';
                replyInput.name = 'reply';
                replyInput.value = replyValue;

                form.appendChild(tokenInput);
                form.appendChild(replyInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
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
