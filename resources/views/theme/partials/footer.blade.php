<footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ route('theme.index') }}" class="logo d-flex align-items-center">
                    <span class="sitename">مهارات هب</span>
                </a>
                <div class="footer-contact pt-3">
                    <p class="mt-3"><strong>الهاتف:</strong> <span>****</span></p>
                    <p><strong>البريد الالاكنروني:</strong> <span>info@maharathub.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/maharathub/" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/maharat-hub" target="_blank"><i
                            class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>روابط مفيدة</h4>
                <ul>
                    <li><a href="{{ route('theme.index') }}">الرئيسية</a></li>
                    <li><a href="{{ route('theme.about') }}">من نحن</a></li>
                    <li><a href="{{ route('theme.skills') }}">مهارات</a></li>
                    <li><a href="{{ route('theme.contact') }}">تواصل معنا</a></li>
                    <li><a href="{{ route('theme.termsOfServices') }}">شروط الاستخدام</a></li>
                    <li><a href="{{ route('theme.privacyPolicy') }}">سياسة الخصوصية</a></li>
                </ul>
            </div>

            {{-- <div class="col-lg-2 col-md-3 footer-links">
                <h4>خدماتنا</h4>
                <ul>
                    <li><a href="#">تصميم المواقع</a></li>
                    <li><a href="#">تطوير الويب</a></li>
                    <li><a href="#">إدارة المنتجات</a></li>
                    <li><a href="#">التسويق</a></li>
                    <li><a href="#">تصميم الجرافيك</a></li>
                </ul>
            </div> --}}

            {{-- <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>النشرة البريدية</h4>
                <p>اشترك في نشرتنا البريدية للحصول على آخر الأخبار حول خدماتنا ومشاريعنا!</p>
                <form action="forms/newsletter.php" method="post" class="php-email-form">
                    <div class="newsletter-form">
                        <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني">
                        <input type="submit" value="اشترك">
                    </div>
                    <div class="loading">جارٍ الإرسال...</div>
                    <div class="error-message"></div>
                    <div class="sent-message">تم إرسال طلب الاشتراك بنجاح. شكرًا لك!</div>
                </form>
            </div> --}}

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>حقوق النشر</span> <strong class="px-1 sitename">مهارات هب</strong> <span>جميع الحقوق محفوظة</span>
        </p>
    </div>

</footer>
