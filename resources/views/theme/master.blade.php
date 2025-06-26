<!DOCTYPE html>
<html lang="ar" dir="rtl">

@include('theme.partials.head')

<body class="index-page">

    @include('theme.partials.header')

    <main class="main">

        @yield('content')

    </main>

    @include('theme.partials.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    @include('theme.partials.scripts')

</body>

</html>
