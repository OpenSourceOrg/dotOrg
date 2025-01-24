<?php
/*
Template Name: /ai/ template
*/
?>

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
    <meta name="description" content="A multi-stakeholder process to define an “Open Source AI”.">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://opensource.org/ai">
    <meta property="og:type" content="website">
    <meta property="og:title" content="The Open Source AI Definition — by The Open Source Initiative">
    <meta property="og:description" content="A multi-stakeholder process to define an “Open Source AI”.">
    <meta property="og:image" content="https://opengraph.b-cdn.net/production/images/759f678a-a340-4fac-8bdd-39d58948634c.jpg?token=fe76lJQvzFTfnaf2xyh8RPjclyoht-lgyebYn-C4BiY&height=1158&width=1200&expires=33265055152">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="opensource.org">
    <meta property="twitter:url" content="https://opensource.org/ai">
    <meta name="twitter:title" content="The Open Source AI Definition — by The Open Source Initiative">
    <meta name="twitter:description" content="A multi-stakeholder process to define an “Open Source AI”.">
    <meta name="twitter:image" content="https://opengraph.b-cdn.net/production/images/759f678a-a340-4fac-8bdd-39d58948634c.jpg?token=fe76lJQvzFTfnaf2xyh8RPjclyoht-lgyebYn-C4BiY&height=1158&width=1200&expires=33265055152">
   
</head>
<?php
    if ( is_user_logged_in() ) {
        wp_admin_bar_render();
    }
    ?>
