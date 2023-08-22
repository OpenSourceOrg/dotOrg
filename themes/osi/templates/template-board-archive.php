<?php
/**
 * Template Name: Board Member Archive
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

	<section class="content--page" id="content-page">
	<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
			<header class="page-header">
				<h1 class="page--title">
					<?php echo esc_html( osi_title() ); ?>
				</h1>
			</header><!-- .page-header -->

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content post--content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-<?php the_ID(); ?>-->

			<?php endwhile; // End of the loop. ?>

		<?php
		$main_query = $wp_query; // save old query
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
		
		// change wp_query so we can use standard archive template part
		$wp_query = new WP_Query( 
			array(
				'post_type'      => 'board-member',
				'paged'          => $paged,
				'posts_per_page' => 20,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'taxonomy-status',
						'field'    => 'slug',
						'terms'    => 'Board Member'
					)
				)
			) 
		);	
		
		if ( have_posts() ) :
			?>
			<div class="archive-columns wp-block-columns" id="content-scroll">
			<?php
			while ( have_posts() ) :
				the_post(); ?>
				<?php get_template_part( 'template-parts/content-archive-board-member' ); ?>
			<?php endwhile; ?>
			</div>
			<?php
		endif;

		$wp_query = $main_query; // reset wp_query
		?>
		<hr>
		<a class="read-more" href="/status/alumni"><?php _e('Alumni', 'osi' ); ?></a>

		</section>

	</main><!-- #primary -->

</section>

<?php
get_footer();
