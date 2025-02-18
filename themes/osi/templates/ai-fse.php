<?php
/*
Template Name: AI Landing Page with FSE
Description: Custom landing page template with Full Site Editing (FSE) capabilities, integrating custom blocks and patterns.
*/

?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	
    <?php
    if ( is_user_logged_in() ) {
        wp_enqueue_style('admin-bar');
        wp_enqueue_script('admin-bar');
     	wp_print_styles('admin-bar');
	}
    ?>
	
	
	<meta name='robots' content='max-image-preview:large' />
	<link rel='dns-prefetch' href='//stats.wp.com' />
	<link rel='dns-prefetch' href='//i0.wp.com' />
	<link rel='dns-prefetch' href='//c0.wp.com' />
	<link rel="alternate" type="application/rss+xml" title="Open Source Initiative &raquo; Feed" href="https://opensource.org/feed" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://opensourceorg.github.io/ai/assets/images/fav.png">
    <script defer data-domain="opensource.org" src="https://plausible.io/js/script.js"></script>
    <!-- fontawesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/plugins/swiper.css">
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/plugins/unicons.css">
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/plugins/metismenu.css">
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/vendor/animate.css">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/vendor/bootstrap.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="https://opensourceorg.github.io/ai/assets/css/style.css">

    <!-- HTML Meta Tags -->
    <title>The Open Source AI Definition — by The Open Source Initiative</title>
    <meta name="description" content="A multi-stakeholder process to define an "Open Source AI".">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://opensource.org/ai">
    <meta property="og:type" content="website">
    <meta property="og:title" content="The Open Source AI Definition — by The Open Source Initiative">
    <meta property="og:description" content="A multi-stakeholder process to define an "Open Source AI".">
    <meta property="og:image" content="https://opengraph.b-cdn.net/production/images/759f678a-a340-4fac-8bdd-39d58948634c.jpg?token=fe76lJQvzFTfnaf2xyh8RPjclyoht-lgyebYn-C4BiY&height=1158&width=1200&expires=33265055152">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="opensource.org">
    <meta property="twitter:url" content="https://opensource.org/ai">
    <meta name="twitter:title" content="The Open Source AI Definition — by The Open Source Initiative">
    <meta name="twitter:description" content="A multi-stakeholder process to define an "Open Source AI".">
    <meta name="twitter:image" content="https://opengraph.b-cdn.net/production/images/759f678a-a340-4fac-8bdd-39d58948634c.jpg?token=fe76lJQvzFTfnaf2xyh8RPjclyoht-lgyebYn-C4BiY&height=1158&width=1200&expires=33265055152">
   
</head>
<?php
    if ( is_user_logged_in() ) {
        wp_admin_bar_render();
    }
    ?>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    
    <header class="header-header-two">
        <!-- header- solaric two -->
        <div class="header-two-solari header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="header-top-m">
                            <div class="left">
                                <div class="header-nav main-nav-one">
                                    <nav>
                                        <ul>
                                            <li>
                                                <a class="nav-link-green" href="https://opensource.org/about">About</a>
                                            </li>
                                            <li>
                                                <a class="nav-link-green" href="https://opensource.org/osd">Open Source Definition</a>
                                            </li>
                                            <li>
                                                <a class="nav-link-green" href="https://opensource.org/licenses">Licenses</a>
                                            </li>
                                            <li>
                                                <a class="nav-link-green" href="https://opensource.org/blog">Blog</a>
                                            </li>
                                            <li>
                                                <a class="nav-link-green" href="https://opensource.org/programs">Programs</a>
                                            </li>
                                            <li>
                                                <a class="nav-link-green" href="https://members.opensource.org/join/">Join</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="right">
                                <div class="social-header-top-h2">
                                    <span>Follow us:</span>
                                    <ul>
                                        <li>
                                            <a href="https://go.opensource.org/mastodon" target="_blank">
                                                <i class="fa-brands fa-mastodon"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://bsky.app/profile/opensource.org" target="_blank">
                                                <i class="fa-brands fa-bluesky"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/company/open-source-initiative-osi-" target="_blank">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.reddit.com/user/opensourceinitiative/" target="_blank">
                                                <i class="fa-brands fa-reddit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header- solaric two end -->
        
        <!-- header main start -->
        <div class="header-main-h2 header--sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-haeder-wrapper-h2">
                            <a href="https://opensource.org/" class="logo-area">
                                <img src="https://i0.wp.com/opensource.org/wp-content/uploads/2023/03/cropped-OSI-horizontal-large.png?fit=640%2C229&amp;ssl=1" alt="Open Source Initiative" style="width:50%">
                            </a>
                            <div class="header-nav main-nav-one" id="nav-links">
                                <nav>
                                    <ul>
                                        <li>
                                            <a class="nav-link" href="https://go.opensource.org/osaid-latest">DEFINITION</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="https://opensource.org/ai/process">PROCESS</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="https://opensource.org/ai/timeline">TIMELINE</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="https://opensource.org/ai/faq" target="_blank">FAQ</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="https://opensource.org/ai/endorsements">ENDORSEMENTS</a>
                                        </li>
                                        <li>
                                            <a href="https://go.opensource.org/osaid-latest" class="rts-btn btn-primary">Read version 1.0</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="actions-area">
                                <div class="menu-btn" id="menu-btn">
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="14" width="20" height="2" fill="#4AAB3D"></rect>
                                        <rect y="7" width="20" height="2" fill="#4AAB3D"></rect>
                                        <rect width="20" height="2" fill="#4AAB3D"></rect>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header main end -->
    </header>


    <!-- Main Content -->
    <main id="main-content">
        <!-- Gutenberg content will be inserted here -->
        hola
    </main>

    <!-- Footer style two -->
    <!-- rts footer area one start -->
    <div class="rts-footer-one footer-bg-one ">
        <div class="container">
            <div class="row g-0 bg-cta-footer-one">
                <div class="col-lg-12">
                    <div class="bg-cta-footer-one wrapper">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <img src="https://opensourceorg.github.io/ai/assets/images/osi-horizontal-white.svg" alt="logo">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="https://opensource.org/join/" class="rts-btn btn-primary" id="join_us">Join us</a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="rts-social-style-one">
                                    <ul>
                                        <li>
                                            <a href="https://go.opensource.org/mastodon" target="_blank">
                                                <i class="fa-brands fa-mastodon"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://bsky.app/profile/opensource.org" target="_blank">
                                                <i class="fa-brands fa-bluesky"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/company/open-source-initiative-osi-" target="_blank">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.reddit.com/user/opensourceinitiative/" target="_blank">
                                                <i class="fa-brands fa-reddit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row pt--90 pb--85 pb_sm--40">
                <div class="col-lg-12">
                    <div class="single-footer-one-wrapper">
                        <div class="single-footer-component first">
                            <div class="title-area">
                                <h5 class="title">The Open Source Initiative</h5>
                            </div>
                            <div class="body">
                                <p class="disc">
                                    The OSI is the authority that defines Open Source, recognized globally by individuals, companies, and by public institutions.
                                </p>
                                <div class="rts-social-style-one">
                                    <ul>
                                        <li>
                                            <a href="https://go.opensource.org/mastodon" target="_blank">
                                                <i class="fa-brands fa-mastodon"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://bsky.app/profile/opensource.org" target="_blank">
                                                <i class="fa-brands fa-bluesky"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/company/open-source-initiative-osi-" target="_blank">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.reddit.com/user/opensourceinitiative/ target="_blank"">
                                                <i class="fa-brands fa-reddit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="single-footer-component">
                            <div class="title-area">
                                <h5 class="title">About</h5>
                            </div>
                            <div class="body">
                                <div class="pages-footer">
                                    <ul>
                                        <li>
                                            <a href="https://opensource.org/about">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>About Us</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/about/team">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Our team</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/associations">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Associations</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/sponsors">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Sponsors</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/articles-of-incorporation">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Articles of Incorporation</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/bylaws">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Bylaws</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/history">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>History</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/trademark-guidelines">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Trademark Guidelines</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="single-footer-component">
                            <div class="title-area">
                                <h5 class="title">Licenses</h5>
                            </div>
                            <div class="body">
                                <div class="pages-footer">
                                    <ul>
                                        <li>
                                            <a href="https://opensource.org/osd">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Open Source Definition</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/licenses">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Licenses</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/licenses/review-process">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>License Review Process</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/osr">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Open Standards Requirement for Software</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                
                        <div class="single-footer-component">
                            <div class="title-area">
                                <h5 class="title">Board</h5>
                            </div>
                            <div class="body">
                                <div class="pages-footer">
                                    <ul>
                                        <li>
                                            <a href="https://opensource.org/about/board-of-directors">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Board of Directors</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/minutes">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Minutes</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/about/board-of-directors/elections">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Elections</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/organization">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Organization & Operations</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/conflict_of_interest_policy">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Conflict of Interest Policy</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://opensource.org/board/board-member-agreement">
                                                <i class="fa-regular fa-chevron-right"></i>
                                                <p>Board member agreement</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb--20 pt--20 border-top-copyright">
                <div class="col-lg-12">
                    <!-- copyright area start -->
                    <div class="copyright-area-one text-center">
                        <div class="left">
                            <p style="text-align:left">The content on this website, of which Opensource.org is the author, is licensed under a&nbsp;<a href="https://web.archive.org/web/20230202005829/https://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.<br><br>Opensource.org is not the author of any of the licenses reproduced on this site. Questions about the copyright in a license should be directed to the license steward.<br />Read our <a href="https://opensource.org/privacy">Privacy Policy</a>.<br /><br />
                            </p>
                        </div>
                        <!-- <div class="right">
                        <ul>
                            <li><a href="#">Terms & conditions</a></li>
                            <li><a href="#">Privacy policy</a></li>
                        </ul>
                    </div> -->
                    </div>
                    <!-- copyright area end -->
                </div>
            </div>
        </div>
        <div class="footer-one-left-right-image">
            <img class="one" src="https://opensourceorg.github.io/ai/assets/images/footer/08.png" alt="">
            <img class="two" src="https://opensourceorg.github.io/ai/assets/images/footer/09.png" alt="">
        </div>
    </div>

    <!-- Footer style two End -->

    <!-- header style two -->

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <div id="anywhere-home" class="">
    </div>


    <!-- jquery js -->
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/jquery.min.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/jqueryui.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/counter-up.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/swiper.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/metismenu.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/waypoint.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/waw.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/gsap.min.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/scrolltigger.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/split-text.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/contact.form.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/vendor/split-type.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/jquery-timepicker.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/plugins/bootstrap.min.js"></script>
    <script src="https://opensourceorg.github.io/ai/assets/js/main.js"></script>
    <!-- header style two End -->
</body>
</html>
