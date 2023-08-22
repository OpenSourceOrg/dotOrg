<?php
if ( function_exists( 'register_block_style' ) ) {
	register_block_style(
		'core/image',
		array(
			'name'         => 'background-round',
			'label'        => __( 'Round Background', 'osi' )
		)
	);
}