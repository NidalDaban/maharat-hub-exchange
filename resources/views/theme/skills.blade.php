@extends('theme.master')
@section('trainers-active', 'active')

@section('content')
    <div class="skills-page rtl" dir="rtl">

        @include('theme.partials.heroSection', [
            'title' => 'مهارات',
            'description' => 'منصة لتبادل المهارات بين الاشخاص',
            'current' => 'مهارات',
        ])

        <div class="container-fluid">
            <form id="filterForm" method="GET" action="{{ route('theme.skills') }}">
                <div class="row">
                    <!-- Sidebar Column -->
                    <div class="col-lg-3 col-md-4 sidebar">
                        <div class="sidebar-card filters-card">
                            <h3 class="sidebar-title">الفلاتر</h3>
                            <div class="filter-section">
                                <h4 class="filter-subtitle">شارة المواهب</h4>
                                <ul class="filter-list">
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="badge1">
                                            <label class="form-check-label" for="badge1">الأعلى تقييماً بلس</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="badge2">
                                            <label class="form-check-label" for="badge2">الأعلى تقييماً</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="badge3">
                                            <label class="form-check-label" for="badge3">موهبة صاعدة</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="accordion" id="userFilterAccordion">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingGender">
                                        <button class="accordion-button collapsed bg-white shadow-none px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseGender" aria-expanded="false"
                                            aria-controls="collapseGender">
                                            الجنس
                                        </button>
                                    </h2>
                                    <div id="collapseGender" class="accordion-collapse collapse"
                                        aria-labelledby="headingGender" data-bs-parent="#userFilterAccordion">
                                        <div class="accordion-body px-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gender_male"
                                                    name="gender[]" value="male"
                                                    {{ in_array('male', request('gender', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gender_male">ذكر</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gender_female"
                                                    name="gender[]" value="female"
                                                    {{ in_array('female', request('gender', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gender_female">انثى</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingCountry">
                                        <button class="accordion-button collapsed bg-white shadow-none px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseCountry"
                                            aria-expanded="false" aria-controls="collapseCountry">
                                            الدولة
                                        </button>
                                    </h2>
                                    <div id="collapseCountry" class="accordion-collapse collapse"
                                        aria-labelledby="headingCountry" data-bs-parent="#userFilterAccordion">
                                        <div class="accordion-body px-0">
                                            @foreach ($countries as $country)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="country_{{ $country->id }}" name="countries[]"
                                                        value="{{ $country->id }}"
                                                        {{ in_array($country->id, request('countries', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="country_{{ $country->id }}">
                                                        {{ $country->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingClassification">
                                        <button class="accordion-button collapsed bg-white shadow-none px-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseClassification"
                                            aria-expanded="false" aria-controls="collapseClassification">
                                            الفئات
                                        </button>
                                    </h2>
                                    <div id="collapseClassification" class="accordion-collapse collapse"
                                        aria-labelledby="headingClassification" data-bs-parent="#userFilterAccordion">
                                        <div class="accordion-body px-0">
                                            @foreach ($classifications as $classification)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="classification_{{ $classification->id }}"
                                                        name="classifications[]" value="{{ $classification->id }}"
                                                        {{ in_array($classification->id, request('classifications', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="classification_{{ $classification->id }}">{{ $classification->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="filter-actions mt-3">
                                <a href="{{ route('theme.skills') }}" class="btn btn-outline-secondary w-100 mt-2">إعادة
                                    تعيين</a>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Main Content Column -->
                    <div class="col-lg-9 col-md-8 main-content">
                        <div class="search-container">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="ابحث عن المهارات أو المواهب..." value="{{ request('search') }}">
                                <button class="btn btn-search" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="content-header">
                            <div class="sort-options">
                                <span>ترتيب حسب:</span>
                                <select class="form-select" name="sort">
                                    <option value="relevant" {{ request('sort') == 'relevant' ? 'selected' : '' }}>الأكثر
                                        صلة</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث
                                    </option>
                                    <option value="top_rated" {{ request('sort') == 'top_rated' ? 'selected' : '' }}>
                                        الأعلى تقييمًا</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="talent-grid"> --}}
                        <div id="users-container" class="users-container">
                            @include('theme.partials.users_grid', ['users' => $users])
                        </div>

                        <!-- Add pagination links below the talent-grid -->
                        <div id="pagination-links" class="mt-4">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
