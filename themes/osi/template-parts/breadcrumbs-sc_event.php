<div class="breadcrumb-area">
	<div class="wrapper">
		<nav class="entry-breadcrumbs" itemscope="" itemtype="https://schema.org/BreadcrumbList">
			<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
				<meta itemprop="position" content="1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-link" itemprop="item" rel="home">
					<span itemprop="name"><?php echo esc_html__( 'Home', 'osi' ); ?></span>
				</a>
			</span>
			<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
				<meta itemprop="position" content="2">
				<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" class="events-link" itemprop="item">
					<span itemprop="name"><?php echo esc_html__( 'Events', 'osi' ); ?></span>
				</a>
			</span>
			<?php if ( is_single() && get_post_type() == 'event' ) : ?>
			<span class="current-page" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
				<meta itemprop="position" content="3">
				<span itemprop="name"><?php echo esc_html( get_the_title() ); ?></span>
			</span>
			<?php endif; ?>
		</nav>
	</div><!-- .wrapper -->
</div><!-- .breadcrumb-area -->
