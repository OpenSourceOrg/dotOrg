<?php if ( function_exists( 'jetpack_breadcrumbs' ) && !is_front_page() ) : ?>
  <div class="breadcrumb-area">
    <div class="wrapper">
      <?php jetpack_breadcrumbs(); ?>
    </div><!-- .wrapper -->
  </div><!-- .breadcrumb-area -->
<?php endif; ?>