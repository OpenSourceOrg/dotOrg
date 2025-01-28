<?php
add_filter('block_editor_rest_api_preload_paths', '__return_empty_array');

add_action('init', function () {
    register_block_pattern_category(
        'ai', // Unique slug for the category
        ['label' => __('AI', 'osi')] // Category label (visible in the editor)
    );
});

function register_about_area_pattern() {
    register_block_pattern(
        'custom/about-area',
        [
            'title'       => __('About Area', 'your-text-domain'),
            'description' => __('A reusable section with tabs and custom content.', 'your-text-domain'),
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
add_action('init', 'register_about_area_pattern');
