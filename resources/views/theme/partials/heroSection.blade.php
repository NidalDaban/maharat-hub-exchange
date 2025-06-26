{{-- <!-- Page Title -->
<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1>{{ $title ?? 'Page Title' }}</h1>
                    <p class="mb-0">{{ $description ?? 'This is the ' . $title . ' page' }}</p>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="{{ route('theme.index') }}">الصفحة الرئيسية</a></li>
                <li class="current">{{ $current ?? $title ?? 'Current Page' }}</li>
            </ol>
        </div>
    </nav>
</div><!-- End Page Title --> --}}


<!-- Page Title -->
<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1>{{ $title ?? 'Page Title' }}</h1>
                    <p class="mb-0">{{ $description ?? 'This is the ' . $title . ' page' }}</p>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="{{ route('theme.index') }}">الصفحة الرئيسية</a></li>
                @if(isset($breadcrumbs))
                    @foreach($breadcrumbs as $breadcrumb)
                        @if(!$loop->last)
                            <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                        @else
                            <li class="current">{{ $breadcrumb['title'] }}</li>
                        @endif
                    @endforeach
                @else
                    <li class="current">{{ $current ?? $title ?? 'Current Page' }}</li>
                @endif
            </ol>
        </div>
    </nav>
</div><!-- End Page Title -->