<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <!-- Auth Section (rightmost element) -->
        <div class="auth-section order-1">
            @auth
                <!-- User dropdown for authenticated users -->
                <div class="dropdown">
                    <a href="#" class="d-flex flex-column align-items-center text-decoration-none dropdown-toggle"
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->image_url }}" alt="صورة المستخدم" width="48" height="48"
                            class="rounded-circle mb-1">

                        <span class="d-none d-md-inline text-center"
                            style="font-size: 0.8rem;">{{ auth()->user()->fullName() ?: auth()->user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start text-small shadow" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item" href="{{ route('myProfile') }}">حسابي</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('invitations.index') }}">دعوات</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('conversations.index') }}">المحادثات</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Login/Register button for guests -->
                <a class="btn-getstarted" href="{{ route('login') }}" style="width: 100%">تسجيل الدخول/انشاء حساب</a>
            @endauth
        </div>

        <!-- Rest of your header code remains the same -->
        <!-- Logo (middle element) -->
        <a href="{{ route('theme.index') }}" class="logo d-flex align-items-center order-2 mx-auto">
            <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/skill-logo-design-template-6677debd608907e81c75e20c66e95baf_screen.jpg?ts=1685817469"
                alt="">
            <h1 class="sitename">مهارات هب</h1>
        </a>

        <!-- Navigation Menu (leftmost element) -->
        <nav id="navmenu" class="navmenu order-3">
            <ul>
                <li><a href="{{ route('theme.index') }}" class="@yield('index-active')">الصفحة الرئيسية</a></li>
                <li><a href="{{ route('theme.about') }}" class="@yield('about-active')">معلومات عنا</a></li>
                <li><a href="{{ route('theme.skills') }}" class="@yield('trainers-active')">مهارات</a></li>
                <li><a href="{{ route('theme.contact') }}" class="@yield('contact-active')">تواصل معنا</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
