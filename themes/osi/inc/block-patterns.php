<?php
function register_osi_patterns() {
    register_block_pattern(
        'osi/ai-header',
        [
            'title'       => __('AI Header', 'osi'),
            'description' => __('Reusable header for AI template.', 'osi'),
            'content'     => '<!-- wp:group {"align":"full"} -->
                <div class="wp-block-group alignfull">
                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">AI Header Content Here</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->',
        ]
    );

    register_block_pattern(
        'osi/ai-footer',
        [
            'title'       => __('AI Footer', 'osi'),
            'description' => __('Reusable footer for AI template.', 'osi'),
            'content'     => '<!-- wp:group {"align":"full"} -->
            <div class="wp-block-group alignfull">
                <p>&copy; ' . date('Y') . ' The Open Source Initiative</p>
                <ul class="wp-block-social-links">
                    <li><a href="https://go.opensource.org/mastodon">Mastodon</a></li>
                    <li><a href="https://bsky.app/profile/opensource.org">Bluesky</a></li>
                    <li><a href="https://www.linkedin.com/company/open-source-initiative-osi-">LinkedIn</a></li>
                    <li><a href="https://www.reddit.com/user/opensourceinitiative/">Reddit</a></li>
                </ul>
            </div>
            <!-- /wp:group -->',
        ]
    );
}
add_action('init', 'register_osi_patterns');