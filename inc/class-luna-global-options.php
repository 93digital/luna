<?php
/**
 * Luna Global Options.
 *
 * Register any custom Global Options sub-pages here using the add_sub_page() method.
 *
 * @package luna
 */

/**
 * Luna Global Options class.
 */
final class Luna_Global_Options extends Luna_Base_Global_Options {
	/**
	 * Construct.
   * Register the Global Options page and fields if ACF is available.
	 */
	public function __construct() {
    if ( ! function_exists( 'get_field' ) ) {
      // ACF isn't active.
      return;
		}

		// Instantiate the base Global Options.
		parent::__construct();

		/**
		 * @example Register sub-page types.
		 */
		$this->add_sub_page( 'Test subpage' );

		return;

		acf_add_local_field_group(
			[
				'key'      => 'group_5da82ac82d0e7',
				'title'    => 'Global Options',
				'fields'   => [
					[
						'key'       => 'field_5da82ad7e6576',
						'label'     => 'Analytics',
						'type'      => 'tab',
						'placement' => 'top',
					],
					[
						'key'   => 'field_5da831d7e6584',
						'label' => 'Google Analytics ID',
						'name'  => 'google_analytics_id',
						'type'  => 'text',
					],
					[
						'key'   => 'field_5da831c7e6583',
						'label' => 'Google Tag Manager',
						'name'  => 'google_tag_manager',
						'type'  => 'text',
					],
					[
						'key'       => 'field_5da830a3e6581',
						'label'     => 'Google Maps',
						'type'      => 'tab',
						'placement' => 'top',
					],
					[
						'key'   => 'field_5da831a8e6582',
						'label' => 'Google Maps Key',
						'name'  => 'google_maps_key',
						'type'  => 'text',
					],
					[
						'key'       => 'field_5da82ae4e6577',
						'label'     => 'Custom Scripts',
						'type'      => 'tab',
						'placement' => 'top',
					],
					[
						'key'          => 'field_5da83021e657f',
						'label'        => 'Header Scripts',
						'name'         => 'header_scripts',
						'type'         => 'textarea',
						'instructions' => 'Custom code inside the head tag',
						'rows'         => 5,
					],
					[
						'key'          => 'field_5da8304be6580',
						'label'        => 'Body Scripts',
						'name'         => 'body_scripts',
						'type'         => 'textarea',
						'instructions' => 'Custom code inside the body tag',
						'rows'         => 5,
					],
					[
						'key'       => 'field_5da82af2e6578',
						'label'     => 'Favicons',
						'type'      => 'tab',
						'placement' => 'top',
					],
					[
						'key'           => 'field_5da82ff9e657e',
						'label'         => 'Favicon (16x16)',
						'name'          => 'favicon_16',
						'type'          => 'image',
						'return_format' => 'url',
						'preview_size'  => 'thumbnail',
						'library'       => 'all',
						'min_width'     => 16,
						'min_height'    => 16,
						'max_width'     => 16,
						'max_height'    => 16,
					],
					[
						'key'           => 'field_5da82fdce657d',
						'label'         => 'Favicon (32x32)',
						'name'          => 'favicon_32',
						'type'          => 'image',
						'return_format' => 'url',
						'preview_size'  => 'thumbnail',
						'library'       => 'all',
						'min_width'     => 32,
						'min_height'    => 32,
						'max_width'     => 32,
						'max_height'    => 32,
					],
					[
						'key'           => 'field_5da82b70e657c',
						'label'         => 'Favicon (Default)',
						'name'          => 'favicon_default',
						'type'          => 'image',
						'instructions'  => 'Your picture should be 260x260 or more for optimal results',
						'return_format' => 'url',
						'preview_size'  => 'thumbnail',
						'library'       => 'all',
						'min_width'     => 70,
						'min_height'    => 70,
					],
					[
						'key'   => 'field_5da82b55e657b',
						'label' => 'Theme Colour',
						'name'  => 'theme_color',
						'type'  => 'color_picker',
					],
					[
						'key'       => 'field_5da82b08e6579',
						'label'     => 'Accessibility',
						'type'      => 'tab',
						'placement' => 'top',
					],
					[
						'key'           => 'field_5da83a54ebfee',
						'label'         => 'Focus Settings',
						'name'          => 'focus_settings',
						'type'          => 'checkbox',
						'instructions'  => '<strong>WARNING:</strong> Turning this off can create a bad user experience for those who suffer from visual impairments. It is generally considered bad practice to switch this off.',
						'choices'       => [
							'accessible' => 'Display focus outline',
						],
						'allow_custom'  => 0,
						'default_value' => [
							0 => 'accessible',
						],
						'return_format' => 'value',
					],
				],
				'location' => [
					[
						[
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'acf-options-general',
						],
					],
				],
			]
		);
	}
}
