<?php if ( !is_front_page() ) : ?>
  <div class="breadcrumb-area">
    <div class="wrapper">
      <?php 
      	$taxonomy                 = is_category() ? 'category' : get_query_var( 'taxonomy' );
        $is_taxonomy_hierarchical = is_taxonomy_hierarchical( $taxonomy );
      
        $post_type                 = is_page() ? 'page' : get_query_var( 'post_type' );
        $is_post_type_hierarchical = is_post_type_hierarchical( $post_type );
      
        if ( ! ( $is_post_type_hierarchical || $is_taxonomy_hierarchical ) || is_front_page() ) {
          return;
        }
      
        $breadcrumb = '';
        $position   = 1;
      
        if ( $is_post_type_hierarchical ) {
          $post_id   = get_queried_object_id();
          $ancestors = array_reverse( get_post_ancestors( $post_id ) );
          if ( $ancestors ) {
            foreach ( $ancestors as $ancestor ) {
              $breadcrumb .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="' . esc_attr( $position ) . '"><a href="' . esc_url( get_permalink( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $ancestor ) ) . '</span></a></span>';
              ++$position;
            }
          }
          $breadcrumb .= '<span class="current-page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="' . esc_attr( $position ) . '"><span itemprop="name">' . esc_html( get_the_title( $post_id ) ) . '</span></span>';
        } elseif ( $is_taxonomy_hierarchical ) {
          $current = get_term( get_queried_object_id(), $taxonomy );
      
          if ( is_wp_error( $current ) ) {
            return;
          }
      
          if ( $current->parent ) {
            $breadcrumb = jetpack_get_term_parents( $current->parent, $taxonomy );
          }
      
          $breadcrumb .= '<span class="current-category" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta property="position" content="' . esc_attr( $position ) . '"><span itemprop="name">' . esc_html( $current->name ) . '</span></span>';
        }
      
        $home      = '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="' . esc_attr( $position ) . '"><meta itemprop="position" content="0"><a href="' . esc_url( home_url( '/' ) ) . '" class="home-link" itemprop="item" rel="home"><span itemprop="name">' . esc_html__( 'Home', 'jetpack' ) . '</span></a></span>';
        
        if ( is_archive() ) {
          $blog_base = '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="' . esc_attr( $position ) . '"><meta itemprop="position" content="0"><a href="' . esc_url( '/news/' ) . '" class="home-link" itemprop="item" rel="home"><span itemprop="name">' . esc_html__( 'News', 'jetpack' ) . '</span></a></span>';
          echo '<nav class="entry-breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">' . $home . $blog_base . $breadcrumb . '</nav>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
          echo '<nav class="entry-breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">' . $home . $breadcrumb . '</nav>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
      ?>
    </div><!-- .wrapper -->
  </div><!-- .breadcrumb-area -->
<?php endif; ?>