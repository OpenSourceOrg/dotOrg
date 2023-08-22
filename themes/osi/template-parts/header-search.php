<section class="header-search-wrapper">

	<div class="search-wrapper--inner">

		<button aria-label="Close Search" id="closeSearch" class="close-search close-button">
			<?php OSI\SVG::the_svg( 'close' ); ?>
		</button>

		<h2 class="search-title"><?php esc_html_e( 'Search Our Site', 'osi' ); ?></h2>

		<div class="search-form-wrapper">
			<p class="search-text"><?php esc_html_e( 'Search', 'osi' ); ?></p>
			<?php get_search_form(); ?>
		</div>

	</div>

</section>
