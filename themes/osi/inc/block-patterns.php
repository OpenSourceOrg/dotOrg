<?php
add_filter('block_editor_rest_api_preload_paths', '__return_empty_array');

add_action('init', function () {
    register_block_pattern_category(
        'ai', // Unique slug for the category
        ['label' => __('AI', 'osi')] // Category label (visible in the editor)
    );
});

function osi_register_about_area_pattern() {
    register_block_pattern(
        'custom/about-area',
        [
            'title'       => __('About Area', 'osi'),
            'description' => __('A reusable section with tabs and custom content.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- rts about area start -->
                <div class="rts-about-area rts-section-gap">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-7 mt_md--30 mt_sm--40">
                                <div class="about-right-content-area-solar-energy">
                                    <div class="title-area-left">
                                        <h2 class="title skew-up">What\'s Open Source AI?</h2>
                                        <p>Following the same idea behind Open Source Software,<br />an Open Source AI is a system made available under terms that grant users the freedoms to:</p>
                                    </div>
                                    <ul class="nav custom-nav-soalr-about nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-use-tab" data-bs-toggle="pill" data-bs-target="#pills-use" type="button" role="tab" aria-controls="pills-use" aria-selected="true">Use</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-study-tab" data-bs-toggle="pill" data-bs-target="#pills-study" type="button" role="tab" aria-controls="pills-study" aria-selected="false">Study</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-modify-tab" data-bs-toggle="pill" data-bs-target="#pills-modify" type="button" role="tab" aria-controls="pills-modify" aria-selected="false">Modify</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-share-tab" data-bs-toggle="pill" data-bs-target="#pills-share" type="button" role="tab" aria-controls="pills-share" aria-selected="false">Share</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-use" role="tabpanel" aria-labelledby="pills-use-tab">
                                            <div class="single-about-content-solar">
                                                <p class="disc">
                                                    <strong>Use the system for any purpose and<br />without having to ask for permission.</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-study" role="tabpanel" aria-labelledby="pills-study-tab">
                                            <div class="single-about-content-solar">
                                                <p class="disc">
                                                    <strong>Study how the system works and<br />understand how its results were created.</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-modify" role="tabpanel" aria-labelledby="pills-modify-tab">
                                            <div class="single-about-content-solar">
                                                <p class="disc">
                                                    <strong>Modify the system for any purpose,<br />including to change its output.</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-share" role="tabpanel" aria-labelledby="pills-share-tab">
                                            <div class="single-about-content-solar">
                                                <p class="disc">
                                                    <strong>Share the system for others to use with<br />or without modifications, for any purpose.</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <p>Precondition to exercise these freedoms is to have access to<br />the preferred form to make modifications to the system, and to the means to use it.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- rts about area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_about_area_pattern');

function osi_register_banner_area_pattern() {
    register_block_pattern(
        'custom/banner-area',
        [
            'title'       => __('Banner Area', 'osi'),
            'description' => __('A banner section with a title, description, and button.', 'osi'),
			'categories'  => ['ai'],
            'content'     => '
                <!-- banner area start -->
                <div class="banner-area-start banner-solar-energy-bg bg_image">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-12 align-items-center">
                                <div class="banner-solar-energy-inner">
                                    <div class="wrapper col-lg-7 mt_md--30 mt_sm--40">
                                        <h1 class="title skew-up">
                                            THE OPEN SOURCE<br />AI DEFINITION 1.0
                                        </h1>
                                        <p class="disc skew-up">
                                            We have released the first stable version of the Definition.
                                        </p>
                                        <div class="button-area">
                                            <a href="https://go.opensource.org/osaid-latest" class="rts-btn btn-primary bg-w">Read version 1.0</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- banner area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_banner_area_pattern');

function osi_register_benefits_area_pattern() {
    register_block_pattern(
        'custom/benefits-area',
        [
            'title'       => __('Benefits Area', 'osi'),
            'description' => __('A section highlighting the benefits of Open Source AI with an accordion and image.', 'osi'),
			'categories'  => ['ai'],
            'content'     => '
                <!-- benefits area start -->
                <div class="faq-section-start-solar rts-section-gapBottom">
                    <div class="container">
                        <div class="row g-24 align-items-start">
                            <div class="col-lg-6">
                                <div class="title-area-left">
                                    <h2 class="title skew-up">
                                        Benefits of Open Source AI
                                    </h2>
                                </div>
                                <div class="accordion-solar-faq">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingOne">
                                                Transparency & Safety
                                            </h3>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    Open Source AI provides information essential for auditing systems and to mitigate bias, ensures accountability and transparency of data sources, and accelerates AI safety research.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingTwo">
                                                Competition & Polyculture
                                            </h3>
                                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    Open Source AI makes more models available, spurs innovation and quality due to increased competition and tackles AI monoculture by providing more stakeholders access to foundational technology.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingThree">
                                                Diverse Applications
                                            </h3>
                                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    Open Source AI gives developers access to resources crucial for developing context-specific, localized applications that are representative of cultural and linguistic diversity and allow for model aligned with different value systems.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl--40">
                                <div class="faq-solari-image-area">
                                    <div class="thumbnail-large-bottom">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/paris-workshop.jpg" alt="OSAID Paris Workshop" class="imgbw">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- benefits area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_benefits_area_pattern');

function osi_register_whitepaper_pattern() {
    register_block_pattern(
        'custom/whitepaper',
        [
            'title'       => __('Whitepaper', 'osi'),
            'description' => __('A section highlighting the Data Governance whitepaper.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- whitepaper area start -->
                <div class="rts-project-details-area rts-section-gapBottom">
                    <div class="container" style="background:#fff; border-radius: 20px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.03)">
                        <div class="row">
                            <div class="col-lg-4">
                                <a href="https://opensource.org/data-governance-open-source-ai">
                                    <img src="https://opensourceorg.github.io/ai/assets/images/data-whitepaper-cover.png" class="imgbw">
                                </a>
                            </div>
                            <div class="col-lg-8 pr--30">
                                <div class="portfolio-disc-content" style="margin-top: 0">
                                    <div class="title-area">
                                        <h4 class="title">Read the Whitepaper</h4>
                                    </div>
                                    <p class="disc">
                                        The Open Source Initiative and Open Future have taken a significant step toward addressing this challenge by releasing this white paper. The document is the culmination of a global co-design process, enriched by insights from a vibrant two-day workshop held in Paris in October 2024.
                                        <br /><br />
                                        <a href="https://opensource.org/data-governance-open-source-ai" class="rts-btn btn-primary">Read the whitepaper</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- whitepaper area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_whitepaper_pattern');

function osi_register_why_ai_definition_pattern() {
    register_block_pattern(
        'custom/why-ai-definition',
        [
            'title'       => __('Why Open Source AI Needs a Definition', 'osi'),
            'description' => __('A section explaining why Open Source AI needs a definition, with three key reasons.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- why area start -->
                <div class="rts-service-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title-area-center">
                                    <h2 class="title skew-up">
                                        Why Open Source AI needs a definition?
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="row g-24 mt--30">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <!-- single why -->
                                <div class="rts-single-service-solar-energy">
                                    <div class="icon">
                                        <i class="fa-brands fa-solid fa-osi" style="font-size:70px;"></i>
                                    </div>
                                    <h3 class="h3titles">Open Source Frontier</h3>
                                    <p class="disc">The traditional view of Open Source code and licenses when applied to AI components are not sufficient to guarantee the freedoms to use, study, share and modify the systems.</p>
                                </div>
                                <!-- single why end -->
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <!-- single why -->
                                <div class="rts-single-service-solar-energy">
                                    <div class="icon">
                                        <i class="fa-solid fa-building-columns" style="font-size:60px;"></i>
                                    </div>
                                    <h3 class="h3titles">Informing Regulators</h3>
                                    <p class="disc">Government regulations have begun in Europe, the United States, and elsewhere. Communities need a common understanding to educate policy makers.</p>
                                </div>
                                <!-- single why end -->
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <!-- single why -->
                                <div class="rts-single-service-solar-energy">
                                    <div class="icon">
                                        <i class="fa-solid fa-hands-bubbles" style="font-size:50px;"></i>
                                    </div>
                                    <h3 class="h3titles">Combat Openwashing</h3>
                                    <p class="disc">Companies are calling AI systems “Open Source” even though their licenses contain restrictions that go against the accepted principles and freedoms of Open Source.</p>
                                </div>
                                <!-- single why end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- why area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_why_ai_definition_pattern');

function osi_register_endorsements_area_pattern() {
    register_block_pattern(
        'custom/endorsements-area',
        [
            'title'       => __('Endorsements Area', 'osi'),
            'description' => __('A section showcasing endorsements with a title, button, and carousel of logos.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- endorsements area start -->
                <div class="rts-Product-area rts-section-gap">
                    <div class="container">
                        <div class="row mb--70">
                            <div class="col-lg-12">
                                <div class="project-soalr-wrapper">
                                    <div class="title-area">
                                        <div class="title-area-left">
                                            <h2 class="title skew-up">
                                               Who\'s behind the Open Source AI Definition
                                            </h2>
                                        </div>
                                    </div>
                                    <a href="https://opensource.org/ai/endorsements" class="rts-btn btn-primary">View All Endorsers</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-120">
                        <div class="row g-24">
                            <div class="col-lg-12">
                                <div class="swiper-h1-solari-main-wrapper">
                                    <div class="swiper mySwiper-h1-solari-product">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/mozilla.png" alt="Mozilla Foundation">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/eleutherai.png" alt="Eleuther AI">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/nextcloud.png" alt="Nextcloud">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/suse.png" alt="SUSE">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/bloomberg.png" alt="Bloomberg Engineering">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/openinfra.png" alt="OpenInfra Foundation">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/eclipse.png" alt="Eclipse Foundation">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/common-crawl.png" alt="Common Crawl">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="rts-solar-single-product-one">
                                                    <a class="thumbnail">
                                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/nerdearla.png" alt="Nerdearla">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- endorsements area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_endorsements_area_pattern');

function osi_register_stats_area_pattern() {
    register_block_pattern(
        'custom/stats-area',
        [
            'title'       => __('Stats Area', 'osi'),
            'description' => __('A section displaying key statistics in a structured grid.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- stats -->
                <div class="rts-funfact fun-fact-bg rts-section-gapBottom">
                    <div class="container">
                        <h3>Overall process</h3>
                        <div class="row g-5">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">20</span>+</h2>
                                        <p>Supporting Organizations</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">100</span>+</h2>
                                        <p>Supporting Individuals</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">50</span>+</h2>
                                        <p>Co-designers</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">13</span></h2>
                                        <p>Systems reviewed</p>
                                    </div>
                                </div>
                            </div>
                            <h3>Representation in the co-design process</h3>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">27</span></h2>
                                        <p>Nationalities</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">42</span>%</h2>
                                        <p>People of Color</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">33</span>%</h2>
                                        <p>Global South</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="single-counter-up-start-solari">
                                    <div class="bg-text"></div>
                                    <div class="main-content">
                                        <h2 class="title"><span class="counter">31</span>%</h2>
                                        <p style="line-height: 3rem;margin-top:14px">Femme, Trans, & Nonbinary</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- stats end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_stats_area_pattern');

function osi_register_process_area_pattern() {
    register_block_pattern(
        'custom/process-area',
        [
            'title'       => __('Process Section', 'osi'),
            'description' => __('A section displaying the co-design and research process, along with endorsements.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- process -->
                <div class="rts-awesome-funfacts-area bg-awesome-feedback">
                    <div class="container-75">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="left-awesome-feedback-wrapper">
                                    <!-- process area -->
                                    <div class="single-awesome-feedback-area large">
                                        <div class="wrapper">
                                            <h2>Co-design</h2>
                                            <h5 class="title skew-up">2023 - 2024</h5>
                                            <p>In 2023, we started the <a href="https://opensource.org/ai/process" style="color: var(--color-primary);">co-design</a> process hosting several <a href="https://opensource.org/ai/timeline" style="color: var(--color-primary);">online and in-person activities</a> around the world.</p>
                                        </div>
                                    </div>
                                    <!-- process area end -->
                                    <!-- process area -->
                                    <div class="single-awesome-feedback-area small">
                                        <div class="wrapper">
                                            <br /><br />
                                            <h2>Research</h2>
                                            <h5 class="title skew-up">2022 - 2023</h5>
                                            <p>Alongside AI experts from various fields we produced a <a href="https://deepdive.opensource.org/podcast/" style="color: var(--color-primary);">podcast</a>, <a href="https://deepdive.opensource.org/panels/" style="color: var(--color-primary);">panels</a>, and <a href="https://opensource.org/ai/webinars" style="color: var(--color-primary);">webinars</a>.</p>
                                        </div>
                                    </div>
                                    <!-- process area end -->
                                </div>
                            </div>
                            <div class="col-lg-6 mt_sm--30">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-xl-6 padding-feedback-top-btm">
                                        <div class="title-area-left">
                                            <h2 class="title skew-up" style="color: var(--color-primary); font-size:4rem">
                                                Endorsements
                                            </h2>
                                            <p class="pre">
                                                <span>2024</span> - 2025
                                            </p>
                                        </div>
                                        <div class="awes-me-fun-f-content">
                                            <p class="disc skew-up">
                                                Late 2024 into 2025, the OSI is gathering <a href="https://opensource.org/ai/endorsements" style="color: var(--color-primary);">endorsements</a> from various individuals and organizations, including Mozilla, Suse, Eleuther AI, Ai2, Eclipse Foundation, and the OpenInfra Foundation, among many others.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6 pl--control-feedback">
                                        <div class="thumbnail">
                                            <img src="https://opensourceorg.github.io/ai/assets/images/codesign.jpg" style="border-radius:50%;" alt="Co-design workshop" class="imgbw">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- process end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_process_area_pattern');


function osi_register_osaid_compliant_systems_pattern() {
    register_block_pattern(
        'custom/osaid-compliant-systems',
        [
            'title'       => __('OSAID Compliant Systems', 'osi'),
            'description' => __('A section listing AI systems that comply with the Open Source AI Definition.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- osaid compliant systems area start -->
                <div class="rts-service-area rts-section-gapTop">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="title-area">
                                    <h4 class="title skew-up">
                                        Which AI systems comply with the OSAID 1.0?
                                    </h4>
                                    <p class="disc" style="text-align:left">
                                        As part of our validation and testing of the OSAID, the volunteers checked whether the Definition could be used to evaluate if AI systems provided the freedoms expected. The list of models that passed the Validation phase are: <strong>Pythia</strong> (Eleuther AI), <strong>OLMo</strong> (AI2), <strong>Amber</strong> and <strong>CrystalCoder</strong> (LLM360), and <strong>T5</strong> (Google).<br><br>
                                        There are a couple of others that were analyzed and would probably pass if they changed their licenses/legal terms: <strong>BLOOM</strong> (BigScience), <strong>Starcoder2</strong> (BigCode), <strong>Falcon</strong> (TII).<br><br>
                                        Those that have been analyzed and don\'t pass because they lack required components and/or their legal agreements are incompatible with the Open Source principles: <strong>Llama2</strong> (Meta), <strong>Grok</strong> (X/Twitter), <strong>Phi-2</strong> (Microsoft), <strong>Mixtral</strong> (Mistral).<br><br>
                                        These results should be seen as part of the definitional process, a learning moment; they\'re not certifications of any kind. OSI will continue to validate only legal documents, and will not validate or review individual AI systems, just as it does not validate or review software projects.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <img src="https://opensourceorg.github.io/ai/assets/images/paris-session.jpg" style="border-radius:20px" class="imgbw">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- osaid compliant systems area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_osaid_compliant_systems_pattern');

function register_how_to_participate_pattern() {
    register_block_pattern(
        'custom/how-to-participate',
        [
            'title'       => __('How to Participate', 'osi'),
            'description' => __('A section explaining how users can get involved with Open Source AI.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- how to participate -->
                <div class="rts-about-style-four rts-section-gap bg-about-h4 rts-section-gapBottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="thumbanil-about-four">
                                    <img src="https://opensourceorg.github.io/ai/assets/images/stef-talk.png" alt="Co-design process" class="imgbw">
                                    <div class="small-bottom-right bg_image">
                                        <h4 class="title">
                                            The OSAID co-design process was open to everyone interested in <a href="https://discuss.opensource.org/faq" target="_blank" style="color: var(--color-primary);">collaborating</a>.
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl--50 pl_md--15 pl_sm--15 mt_md--50 mt_sm--50">
                                <div class="solari-title-area-four">
                                    <h2 class="title skew-up">How to participate</h2>
                                </div>
                                <div class="about-inner-four-h4">
                                    <p class="disc">
                                        There are many ways to get involved:
                                    </p>
                                    <ul>
                                        <li><a href="https://opensource.org/ai/endorsements">Endorse the Open Source AI Definition</a>: have your organization appended to the list of supporters of version 1.0.</li>
                                        <li>Join the <a target="_blank" href="https://discuss.opensource.org/">forum</a>: support and comment on the releases, record your approval or concerns to new and existing threads.</li>
                                        <li>Subscribe to <a href="https://opensource.org/newsletter">our newsletter</a> and read <a href="https://opensource.org/blog">our blog</a> to be kept up-to-date.</li>
                                        <li>Watch the <a href="https://opensource.org/ai/townhalls">town hall</a> recordings to learn more about the process.</li>
                                        <li>Join the <a href="https://opensource.org/events">workshops and scheduled conferences</a>: meet the OSI and other participants at in-person events around the world.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- how to participate end -->
            ',
        ]
    );
}
add_action('init', 'register_how_to_participate_pattern');

function osi_register_governance_pattern() {
    register_block_pattern(
        'custom/governance-area',
        [
            'title'       => __('Governance', 'osi'),
            'description' => __('A section explaining the governance of the Open Source AI Definition.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- rts governance area start -->
                <div class="rts-project-details-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 pr--30">
                                <div class="portfolio-disc-content" style="margin-top: 0">
                                    <div class="title-area">
                                        <h4 class="title">Open Source AI Definition Governance</h4>
                                    </div>
                                    <p class="disc">
                                        Governance for the Open Source AI Definition is provided by the <strong><a href="https://opensource.org/about/board-of-directors">OSI Board of Directors</a></strong>. The OSI board members have expertise in business, legal, and open source software development, as well as experience across a range of commercial, public sector, and non-profit organizations. Formal progress reports including achievements, budget updates, and next steps are provided monthly by the Program Lead for advice and guidance as part of regular Board business. Additionally, informal updates on the outcomes of key meetings and milestones are provided via email to the Board as required.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <img src="https://opensourceorg.github.io/ai/assets/images/ato2023.png" style="padding-bottom:120px" class="imgbw">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- rts governance area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_governance_pattern');

function osi_register_quotes_pattern() {
        register_block_pattern(
            'custom/quotes-area',
            [
                'title'       => __('Individual Endorsers', 'osi'),
                'description' => __('A section displaying quotes from endorsers of the Open Source AI Definition.', 'osi'),
                'categories'  => ['ai'],
                'content'     => '
                    <!-- quotes area start -->
                    <div class="rts-feedback-area-solar-energy rts-section-gap">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="title-area-center">
                                        <h2 class="title skew-up">Individual Endorsers</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt--30 g-24">
                                <div class="soalr-feedback-wrapper-main">
                                    <div class="swiper swiper-feedback-solar">
                                        <div class="swiper-wrapper">
                                            <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/hector-liu.jpeg" alt="Hector Zhengzhong Liu" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "LLM360 finds that OSI’s Open Source AI definition is a meaningful, reasonable, and holistic standard which will have positive reverberations throughout the community. The definition clarifies the unique challenges surrounding open source AI including the expectations for disseminating code, data, and accessibility requirements. This definition propels the open source ecosystem and aligns with LLM360’s mission for community owned AI. Our team is thrilled and excited to fully support OSI’s efforts on advancing the Open Source AI definition."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Hector Zhengzhong Liu, LLM360</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/percy-liang.jpg" alt="Percy Liang" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Coming up with the proper open-source definition is challenging given restrictions on data, but I\'m glad to see that the OSI v1.0 definition requires at least that the complete code for data processing (the primary driver of model quality) be open-source.  The devil is in the details, so I\'m sure we\'ll have more to say once we have concrete examples of people trying to apply this Definition to their models."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Percy Liang, Director of Center for Research on Foundation Models, Stanford University</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/arun-gupta.jpg" alt="Arun Gupta" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            “Facilitating an Open ecosystem is an important part of our approach at Intel. An open approach to AI can foster greater collaboration across the community, drive innovation and enhance transparency. We applaud OSI’s efforts to expand their definition to include AI models and datasets. OSI’s creation of a first revision of the definition, can help industry continue to evolve and iterate.”
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Arun Gupta, Vice President and General Manager, Open Ecosystem, Intel</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/liv-marte.jpeg" alt="Liv Marte Kristiansen Nordhaug" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "We welcome OSI\'s stewardship of the complex process of defining open source AI. The Digital Public Goods Alliance secretariat will build on this foundational work as we update the DPG Standard as it relates to AI as a category of DPGs"
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Liv Marte Kristiansen Nordhaug, CEO of the Digital Public Goods Alliance</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/aviya-skowron.jpeg" alt="Aviya Skowron" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Transparency is at the core of EleutherAI’s non-profit mission. The Open Source AI Definition is a necessary step towards promoting the benefits of open source principles in the field of AI. We believe that this definition supports the needs of independent machine learning researchers and promotes greater transparency among the largest AI developers."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Aviya Skowron, Head of Policy and Ethics at Eleuther AI</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/aviya-skowron.jpeg" alt="Aviya Skowron" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "The Common Crawl Foundation fully supports the Open Source AI Definition as a crucial step in setting clear standards for open and transparent AI development.  This definition will help ensure AI develops responsibly, staying open and accessible to everyone."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Thom Vaughan, Principal Technologist, Common Crawl Foundation</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/stella-biderman.jpeg" alt="Stella Biderman" style="width:200px";>
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Transparency is at the core of EleutherAI’s non-profit mission. The Open Source AI Definition is a necessary step towards promoting the benefits of open source principles in the field of AI. We believe that this definition supports the needs of independent machine learning researchers and promotes greater transparency among the largest AI developers."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Stella Biderman, AI and NLP Researcher, EleutherAI</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/alan-clark.jpg" alt="Alan Clark">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "SUSE applauds the progress made by the Open Source Initiative and its Open Source AI Definition. The efforts are culminating in a very thorough definition, which is important for the quickly evolving AI landscape and the role of open source within it. We commend the process OSI is utilizing to arrive at the definition and the adherence to the open source methodologies. Clarity and consensus drive collaboration, and we believe this definition will drive open source AI forward."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Alan Clark, Office Of The CTO, SUSE</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/yann-lechelle.jpeg" alt="Yann Lechelle" style="width: 200px">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "I endorse! We need common vocabulary to define what is open is what isn\'t. This is a solid framework that doesn\'t give a blank check to those who are lightly claiming to be providing open source AI (even if they desperately wish to be qualified as such), and reversely, the framework is open to initiatives that introduce gradients of open source on the various components that make an AI system, and recognizes efforts in opening-up all or some of the components. After all, "AI" is a derivative of software, complete with data, code and artefacts. There is no reason a derivative system should be classified under the foundational definition of "open source" and at the same time, AI systems are becoming so powerful at capturing intelligence away from humans that we need to qualify their degree of openness. Hats off to all involved for producing such an important piece of work."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Yann Lechelle, Co-founder CEO @ :probabl.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/mark-collier.jpeg" alt="Mark Collier" style="width: 200px">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "This effort you and OSI team have been driving is really important and I’m a believer that time is becoming of the essence. Inevitably it will need to evolve but putting a stamp on it soon is important. We have to define what open source means in the context of AI models in order to preserve the permissionless innovation aspect that created so much value with open source software licenses. The definition is both pragmatic and challenging, and is an excellent first step in a fast-moving area."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Mark Collier, Chief Operating Officer at OpenStack Foundation</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/seo-young-isabelle-hwang.jpeg" alt="Seo-Young Isabelle Hwang" style="width: 200px">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "The codesign process allowed me to see first hand the thought process of people all over the world about what is open source AI. It may never be possible for all the people to agree on the definition. But It is a wonderful start and I think everyone will agree that the open discussions, seminars, townhall meetings, follow up surveys, emails are all very effective and "democratic" :-)"
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Victor Lu, Independent Consultant</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
																	   <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="" alt="" style="width: 200px">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Software Heritage is committed to preserving and making accessible the invaluable human knowledge embedded in software source code. We believe that AI systems trained on this vast repository should be freely available to all, with as little restrictions as possible.<br />Users of OSAID-compliant AI systems trained on Software Heritage data will enjoy full transparency on how they were built. By endorsing OSAID, we aim to promote transparency and reproducibility within the AI industry. We\'ve been involved and vocal in shaping OSAID 1.0 and look forward to collaborating on further iterations of it, as the practice of developing AI systems from open data sets evolves."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Stefano Zacchiroli, co-founder and CSO of Software Heritage</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/shuji-sado.jpeg" alt="Shuji Sado">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Open Source Group Japan commends OSI for its leadership in navigating the complex process of defining Open Source AI, and we fully support the Open Source AI Definition (OSAID) as a key standard for open and transparent AI systems. The field of AI is evolving rapidly, and the need for a clear and consistent definition of Open Source AI has never been more critical. OSI\'s OSAID marks a crucial milestone toward a future where collaboration and openness are the norms in AI development. We anticipate that this will drive innovation, transparency, and the ethical development of AI systems."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Shuji Sado, Chairman, Open Source Group Japan</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- quotes end -->
                            </div>
                            <div class="swiper-slide">
                                <!-- quotes -->
                                <div class="rts-single-feedback-solar-energy">
                                    <!-- <div class="client-image">
                                        <img src="https://opensourceorg.github.io/ai/assets/images/supporters/oscar-mullin.jpeg" alt="Oscar Mullin" style="width: 200px">
                                    </div> -->
                                    <div class="content">
                                        <p class="para">
                                            "Open Source generative AI models are one of the keys to the advancement of the field. By enabling a community of developers and researchers to collaborate and evolve these models in a responsible way, we can greatly benefit a wide range of applications."
                                        </p>
                                        <div class="cottom-review-area">
                                            <p>Oscar Mullin, VP of Technology - Cloud Services, Data & AI at MercadoLibre</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                <!-- quotes end -->
                                        <div class="swiper-pagination"></div>
                                    </div>
                                </div>
                            </div>
                    <!-- quotes area end -->
                ',
            ]
        );
    }
    add_action('init', 'osi_register_quotes_pattern');

function osi_register_brand_pattern() {
    register_block_pattern(
        'custom/brand-area',
        [
            'title'       => __('Supported by (Brand Area)', 'osi'),
            'description' => __('A section displaying organizations supporting the Open Source AI initiative.', 'osi'),
            'categories'  => ['ai'],
            'content'     => '
                <!-- rts brand area start -->
                <div class="rts-Product-area rts-section-gap" style="padding-bottom:50px">
                    <div class="container">
                        <div class="row mb--70">
                            <div class="col-lg-12">
                                <!-- project title btn main wrapper -->
                                <div class="project-soalr-wrapper">
                                    <div class="title-area">
                                        <div class="title-area-left">
                                            <h2 class="title skew-up">Supported by</h2>
                                        </div>
                                    </div>
                                </div>
                                <!-- project title btn main wrapper end -->
                            </div>
                        </div>
                    </div>
                    <div class="rts-brand-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="brand-area-h2">
                                        <a href="#"><img src="https://i0.wp.com/opensource.org/wp-content/uploads/2024/05/Logo-2B-SMALL-Gold-Blue.png?resize=768%2C150&ssl=1" alt="brand_start"></a>
                                        <a href="#"><img src="https://i0.wp.com/opensource.org/wp-content/uploads/2024/08/cisco.png?w=640&ssl=1" alt="brand_start"></a>
                                        <a href="#"><img src="https://i0.wp.com/opensource.org/wp-content/uploads/2024/08/google-open-source.png?w=640&ssl=1" alt="brand_start"></a>
                                        <a href="#"><img src="https://i0.wp.com/opensource.org/wp-content/uploads/2024/08/meli.png?w=640&ssl=1" alt="brand_start"></a>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <p>OSI’s efforts wouldn’t be possible without the support of our sponsors and thousands of individual members.<br />
                                <strong><a href="https://opensource.org/sponsors">Become a sponsor</a></strong> or <strong><a href="http://members.opensource.org/join#join">join us today!</a></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- rts brand area end -->
            ',
        ]
    );
}
add_action('init', 'osi_register_brand_pattern');

function allow_font_awesome_icons($tags) {
    $tags['i'] = array(
        'class' => true,
        'style' => true
    );
    $tags['span'] = array(
        'class' => true,
        'style' => true
    );
    return $tags;
}
add_filter('wp_kses_allowed_html', 'allow_font_awesome_icons', 10, 2);