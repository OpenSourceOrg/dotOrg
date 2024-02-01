<?php
// You can edit reusable blocks by going to /wp-admin/edit.php?post_type=wp_block
$email_block = get_page_by_title( 'Email Signup Form Block', OBJECT, 'wp_block' );
if ( $email_block ) {
    echo apply_filters( 'the_content', $email_block->post_content );
}