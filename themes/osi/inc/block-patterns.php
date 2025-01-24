<?php
add_filter('block_editor_rest_api_preload_paths', '__return_empty_array');

add_action('init', function () {
    register_block_pattern_category(
        'ai', // Unique slug for the category
        ['label' => __('AI', 'osi')] // Category label (visible in the editor)
    );
});

function register_osi_patterns() {
    register_block_pattern(
        'osi/ai-header',
        [
            'title'       => __('AI Header', 'osi'),
            'description' => __('Reusable header for AI template.', 'osi'),
            'categories'  => ['ai'],
            'content'     => <<<HTML
            <!-- wp:group {"align":"full"} -->
            <div class="wp-block-group alignfull header-header-two">
                <!-- wp:html -->
                <div class="header-two-solari header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="header-top-m">
                                    <div class="left">
                                        <nav>
                                            <ul>
                                                <li><a href="https://opensource.org/about">About</a></li>
                                                <li><a href="https://opensource.org/osd">Open Source Definition</a></li>
                                                <li><a href="https://opensource.org/licenses">Licenses</a></li>
                                                <li><a href="https://opensource.org/blog">Blog</a></li>
                                                <li><a href="https://opensource.org/programs">Programs</a></li>
                                                <li><a href="https://members.opensource.org/join/">Join</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="right">
                                        <ul class="social-header-top-h2">
                                            <li><a href="https://go.opensource.org/mastodon"><i class="fa-brands fa-mastodon"></i></a></li>
                                            <li><a href="https://bsky.app/profile/opensource.org"><i class="fa-brands fa-bluesky"></i></a></li>
                                            <li><a href="https://www.linkedin.com/company/open-source-initiative-osi-"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                            <li><a href="https://www.reddit.com/user/opensourceinitiative/"><i class="fa-brands fa-reddit"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /wp:html -->
            </div>
            <!-- /wp:group -->
            HTML,
        ]
    );

    register_block_pattern(
        'osi/ai-banner',
        [
            'title'       => __('AI Banner', 'osi'),
            'description' => __('Reusable banner for the AI template.', 'osi'),
            'content'     => '<!-- wp:group {"align":"full"} -->
                <div class="wp-block-group alignfull banner-area-start">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="banner-solar-energy-inner">
                                    <h1 class="title">The Open Source AI Definition 1.0</h1>
                                    <p class="disc">We have released the first stable version of the Definition.</p>
                                    <div class="button-area">
                                        <a href="https://go.opensource.org/osaid-latest" class="rts-btn btn-primary bg-w">Read version 1.0</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /wp:group -->',
        ]
    );

    register_block_pattern(
        'osi/ai-about',
        [
            'title'       => __('AI About Section', 'osi'),
            'description' => __('What is Open Source AI?', 'osi'),
            'content'     => '<!-- wp:group {"align":"full"} -->
                <div class="wp-block-group alignfull rts-about-area">
                    <div class="container">
                        <h2>What\'s Open Source AI?</h2>
                        <p>
                            Following the same idea behind Open Source Software, Open Source AI is a system made available under terms that grant users the freedoms to:
                        </p>
                        <ul>
                            <li>Use the system for any purpose</li>
                            <li>Study how the system works</li>
                            <li>Modify the system for any purpose</li>
                            <li>Share the system with others</li>
                        </ul>
                    </div>
                </div>
                <!-- /wp:group -->',
        ]
    );

    register_block_pattern(
        'osi/ai-footer',
        [
            'title'       => __('AI Footer', 'osi'),
            'description' => __('Reusable footer for the AI template.', 'osi'),
            'content'     => '<!-- wp:group {"align":"full"} -->
                <div class="wp-block-group alignfull rts-footer-one footer-bg-one">
                    <div class="container">
                        <div class="row g-0 bg-cta-footer-one">
                            <div class="col-lg-3">
                                <img src="https://opensourceorg.github.io/ai/assets/images/osi-horizontal-white.svg" alt="logo">
                            </div>
                            <div class="col-lg-3">
                                <a href="https://opensource.org/join/" class="rts-btn btn-primary">Join Us</a>
                            </div>
                            <div class="col-lg-3">
                                <ul>
                                    <li><a href="https://go.opensource.org/mastodon"><i class="fa-brands fa-mastodon"></i></a></li>
                                    <li><a href="https://bsky.app/profile/opensource.org"><i class="fa-brands fa-bluesky"></i></a></li>
                                    <li><a href="https://www.linkedin.com/company/open-source-initiative-osi-"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    <li><a href="https://www.reddit.com/user/opensourceinitiative/"><i class="fa-brands fa-reddit"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <p>&copy; ' . date('Y') . ' The Open Source Initiative. All Rights Reserved.</p>
                    </div>
                </div>
                <!-- /wp:group -->',
        ]
    );
}
add_action('init', 'register_osi_patterns');