<?php
/**
 * ACF Gutenberg Block Registration.
 *
 * @package luna
 */

namespace Luna\Gutenberg\Blocks;

/**
 * Register ACF Blocks.
 */
function register_acf_block_types() {
	acf_register_block_type(
		[
			'name'            => 'luna-block',
			'title'           => __( 'Luna block', 'luna' ),
			'description'     => __( 'Luna block description.', 'luna' ),
			'render_template' => 'modules/m00-luna-block.php',
			'category'        => 'luna-blocks',
			'icon'            => 'align-center',
			'keywords'        => [ 'acf', 'luna' ],
			'supports'        => [
				'mode'     => false,
				'align'    => false,
				'multiple' => true,
			],
		]
	);
}

// Check if function exists and hook into setup.
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', __NAMESPACE__ . '\register_acf_block_types' );
}
