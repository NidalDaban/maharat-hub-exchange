@extends('theme.master')
@section('index-active', 'active')

@section('content')

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

        <div class="container">
            {{-- <h2 data-aos="fade-up" data-aos-delay="100">نتعلم اليوم،<br>لنقود الغد</h2> --}}
            <h2 data-aos="fade-up" data-aos-delay="100">ماذا تريد أن تتعلم اليوم؟</h2>
            <p data-aos="fade-up" data-aos-delay="200">انضم إلى مجتمع نابض بالحياة حيث يلتقي التعلم بالفرص. منصة مهارات هَب
                تتيح للأفراد مشاركة خبراتهم وتبادل المهارات لبناء مستقبل أفضل وتحقيق النمو معًا.</p>


            <!-- Updated Search Section -->
            <div class="search-container" data-aos="fade-up" data-aos-delay="300">
                <!-- Tabs -->
                {{-- <div class="tabs mb-4">
                    <button class="tab-button active">ابحث عن مهارة</button>
                </div> --}}

                <!-- Search Bar & Filters -->
                <div class="search-wrapper">
                    <div class="search-bar">
                        <div class="search-input">
                            <input type="text" placeholder="ابحث عن المهارة">
                            <button class="search-button">
                                <i class="bi bi-search"></i> بحث
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </section>

    <!-- Why Skills Hub Section -->
    <section id="why-skills-hub" class="why-skills-hub section">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>لماذا مهارات هَب؟</h2>
                <p>نهدف إلى تسهيل عملية تعلم المهارات الجديدة، مشاركة الدورات، وبناء مجتمع تعليمي مستدام</p>
            </div>

            <div class="row gy-4">

                <!-- Skill Exchange -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <h3>تبادل المهارات</h3>
                        <p>تبادل خبراتك مع الآخرين. علّم ما تعرفه، وتعلم ما لا تعرفه.</p>
                    </div>
                </div>

                <!-- Free or Low Cost -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <h3>مجاني أو بتكلفة منخفضة</h3>
                        <p>نوفر لك الوصول إلى مهارات عالية الجودة دون أي عبء مالي</p>
                    </div>
                </div>

                <!-- Community Concept -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>مدفوع المجتمع</h3>
                        <p>كن جزءًا من مجتمع نابض بالحماس، حيث يتشارك الجميع شغف التعلم والمعرفة.</p>
                    </div>
                </div>

                <!-- Skill Verification -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h3>التحقق من المهارات</h3>
                        <p>اكسب شارات وتحققات للمهارات التي أتقنتها لإظهار قدراتك.</p>
                    </div>
                </div>

                <!-- Flexible Scheduling -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3>جدولة مرنة</h3>
                        <p>حدد جدولك الخاص والتقي افتراضيًا أو شخصيًا، حسب ما يناسبك.</p>
                    </div>
                </div>

                <!-- Continuous Learning -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box h-100">
                        <div class="icon-box bg-primary text-white mb-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h3>وصول عالمي</h3>
                        <p>تواصل مع أشخاص من جميع أنحاء العالم وتبادل المهارات عبر الحدود الثقافية.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Why Skills Hub Section -->

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works section">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>كيف تعمل مهارات هَب؟</h2>
                <p>انضم إلى منصتنا بثلاث خطوات بسيطة وابدأ بتبادل المهارات اليوم.</p>
            </div>

            <div class="row gy-4 justify-content-center" id="index-row">
                <!-- Step 1 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-box text-center h-100">
                        <div class="step-number bg-primary text-white mb-3">١</div>
                        <h3>أنشئ ملفك الشخصي</h3>
                        <p>سجّل وحدد المهارات التي يمكنك تعليمها للآخرين.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-box text-center h-100">
                        <div class="step-number bg-primary text-white mb-3">٢</div>
                        <h3>تواصل مع الآخرين</h3>
                        <p>تصفح أو اعثر على الأشخاص الذين يريدون تعلم ما تعلمه ويمكنهم تعليمك ما تريد تعلمه.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-box text-center h-100">
                        <div class="step-number bg-primary text-white mb-3">٣</div>
                        <h3>ابدأ بالتبادل</h3>
                        <p>تواصل، وحدد المواعيد، وابدأ بتبادل المعرفة والمهارات مع شريك التعلم الجديد الخاص بك.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /How It Works Section -->

    <!-- Updated Growing Community Section -->
    <section id="community" class="community section bg-light">
        <div class="container">
            <div class="row align-items-center" id="row-community-id">
                <!-- Image on the left -->
                <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    <img src="https://www.en.agraria.unina.it/images/2023/05/31/courses4.png" id="img-fluid"
                        class="img-fluid rounded" alt="مجتمع مهارات هب">
                </div>

                <!-- Content on the right -->
                <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                    <div class="pe-lg-5">
                        <h2 class="mb-4">انضم إلى مجتمعنا المتنامي</h2>
                        <p class="lead mb-4">مهارات هب هي أكثر من مجرد منصة - إنها مجتمع من المتعلمين والمعلمين المتحمسين
                            يجتمعون معًا لمشاركة المعرفة.</p>

                        <div class="community-features">
                            <div class="feature-item d-flex mb-4">
                                <div class="icon-box bg-primary text-white me-3 flex-shrink-0">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <p class="mb-0 feature-text">تواصل مع أشخاص يفكرون بنفس طريقتك ويشاركونك اهتماماتك</p>
                                </div>
                            </div>

                            <div class="feature-item d-flex mb-4">
                                <div class="icon-box bg-primary text-white me-3 flex-shrink-0">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <p class="mb-0 feature-text">شارك في فعاليات المجتمع وجلسات التعلم الجماعية</p>
                                </div>
                            </div>

                            <div class="feature-item d-flex">
                                <div class="icon-box bg-primary text-white me-3 flex-shrink-0">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <p class="mb-0 feature-text">ابنِ علاقات ذات مغزى أثناء تنمية مهاراتك</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section id="faq" class="faq section">
        <div class="container" data-aos="fade-up">

            <div class="section-title text-right">
                <h2 id="faq-header">الأسئلة الشائعة</h2>
                <p>احصل على إجابات للأسئلة الشائعة حول مهارات هب</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">

                    <div class="accordion" id="faqAccordion">

                        <!-- FAQ Item 1 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1" style="color: #37423b !important">
                                    كيف يعمل تبادل المهارات؟
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    تطابق مهارات هب المستخدمين بناءً على المهارات التكميلية. سيتم ربطك مع أشخاص يريدون تعلم
                                    ما يمكنك تعليمه، ويمكنهم تعليمك ما تريد تعلمه. يمكنك بعد ذلك ترتيب الجلسات إما افتراضيًا
                                    أو شخصيًا، حسب تفضيلاتك.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2" style="color: #37423b !important">
                                    هل مهارات هب مجانية تماماً؟
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    نعم، جميع تبادلات المهارات على مهارات هب مجانية تمامًا - لأننا نؤمن بأن المعرفة يجب أن
                                    تُشارك بشكل مفتوح وبدون حواجز. ومع ذلك، لضمان استدامة المنصة واستمرار تطورها، تُقدم بعض
                                    الميزات المتقدمة وغير المحدودة حصريًا من خلال اشتراكنا المميز.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3" style="color: #37423b !important">
                                    كيف أكسب وأستبدل النقاط؟
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    النقاط هي نظام مكافآت صُمّم لتعزيز تجربة التعلّم على منصتنا. يمكنك كسب النقاط من خلال
                                    إكمال تبادلات المهارات، وتسجيل الدخول اليومي، ودعوة الأصدقاء. ويمكنك استبدال هذه النقاط
                                    مقابل مزايا حصرية مثل الوصول إلى النسخة المدفوعة، وخصومات من شركائنا، وجوائز، أو حضور
                                    ندوات خاصة.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4" style="color: #37423b !important">
                                    ماذا لو أردت تعليم شخص ما، ولكنه لا يستطيع تقديم أي شيء في المقابل؟
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    إذا كنت منفتحًا على التعليم دون توقع مقابل، فستحصل على 1.5 ضعف النقاط مقابل مشاركة
                                    معرفتك ومساعدة الآخرين. يمكنك تفعيل هذا الخيار من ملفك الشخصي، وسيعرض النظام الأشخاص
                                    الأنسب بناءً على تفضيلاتك. هذا لا يحد من قدرتك على المشاركة في التبادلات المتبادلة، بل
                                    يمنحك مرونة أكبر للمساعدة وكسب مكافآت إضافية.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq5" style="color: #37423b !important">
                                    كيف تتحقق مهارات هب من مهارات المستخدم؟
                                </button>
                            </h3>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    نستخدم مجموعة من مراجعات الأقران وتقييمات المهارات وشارات التحقق. يمكن للمستخدمين كسب
                                    شارات من خلال إظهار مهاراتهم وتلقي ملاحظات إيجابية من شركاء التعلم. يخلق هذا مجتمعًا
                                    موثوقًا به من مشاركي المهارات المعتمدين.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 6 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq6" style="color: #37423b !important">
                                    متى سيتم إطلاق مهارات هب؟
                                </button>
                            </h3>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    المنصة حالياً قيد التطوير بعد أن فازت الفكرة في هاكاثون رواد الأعمال 2024 من وزارة
                                    الاقتصاد الرقمي والريادة الأردنية. انضم إلى قائمة الانتظار لتكون من أوائل من يعرف عندما
                                    يتم الإطلاق وللحصول على وصول مبكر حصري.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 7 -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq7" style="color: #37423b !important">
                                    ما نوع المهارات التي يمكن تبادلها؟
                                </button>
                            </h3>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    يمكن تبادل أي مهارة تقريبًا على منصتنا! سواء كانت مهارات إبداعية مثل التصوير والموسيقى،
                                    أو مهارات تقنية مثل البرمجة والتسويق الرقمي، أو مهارات يومية مثل تعلم اللغات والطبخ
                                    واللياقة البدنية والمواد الأكاديمية - إذا كان بإمكانك تعليمها، يمكنك تبادلها.
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- /FAQs Section -->

@endsection
