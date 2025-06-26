@extends('theme.master')
@section('contact-active', 'active')

@section('content')
    <main class="main">

        @include('theme.partials.heroSection', [
            'title' => 'تواصل معنا',
            'description' => 'تواصل معنا لمعرفة المزيد',
            'current' => 'تواصل معنا',
        ])

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-between align-items-start">

                    <!-- Info Section -->
                    <div class="col-lg-4">
                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-building flex-shrink-0 me-3"></i>
                            <div>
                                <h3>مهارات هب</h3>
                                <p>******************</p>
                            </div>
                        </div>

                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-envelope flex-shrink-0 me-3"></i>
                            <div>
                                <h3>بريدنا الالكتروني</h3>
                                <p>info@maharathub.com</p>
                            </div>
                        </div>

                        <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-telephone flex-shrink-0 me-3"></i>
                            <div>
                                <h3>اتصل بنا</h3>
                                <p>**********</p>
                            </div>
                        </div>
                    </div>


                    <!-- Form Section -->
                    {{-- <div class="col-lg-8">
                        <form action="forms/contact.php" method="post" class="php-email-form p-4" data-aos="fade-up"
                            data-aos-delay="200" style="border: 1px solid #333; border-radius: 0.25rem;">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="first-name" class="form-control" placeholder="الاسم الأول"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last-name" placeholder="الاسم الأخير"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="البريد الإلكتروني" required>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" placeholder="رقم الهاتف"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <select name="service" class="form-control" required>
                                        <option value="" selected disabled>اختر الخدمة</option>
                                        <option value="cooperation">تعاون معنا</option>
                                        <option value="complaints">شكاوى</option>
                                        <option value="complaints">اقتراحات</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="الرسالة..." required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">جاري الإرسال...</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">تم إرسال رسالتك. شكرًا لك!</div>
                                    <button type="submit" class="btn btn-primary">إرسال</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}

                    <!-- Form Section -->
                    <div class="col-lg-8">
                        <form action="{{ route('contact.submit') }}" method="POST" class="p-4"
                            style="border: 1px solid #333; border-radius: 0.25rem;">
                            @csrf

                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="الاسم الأول" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="الاسم الأخير" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror" placeholder="رقم الهاتف"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <select name="service" class="form-control @error('service') is-invalid @enderror"
                                        required>
                                        <option value="" selected disabled>اختر الخدمة</option>
                                        <option value="collaboration"
                                            {{ old('service') == 'collaboration' ? 'selected' : '' }}>تعاون معنا</option>
                                        <option value="Complaints" {{ old('service') == 'Complaints' ? 'selected' : '' }}>
                                            شكاوى</option>
                                        <option value="note" {{ old('service') == 'note' ? 'selected' : '' }}>اقتراحات
                                        </option>
                                    </select>
                                    @error('service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="6"
                                        placeholder="الرسالة..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 text-center">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary">إرسال</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </section><!-- /Contact Section -->

    </main>
@endsection
