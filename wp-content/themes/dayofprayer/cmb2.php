<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * Be sure to replace all instances of 'dxl_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function dxl_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function cmb2_get_soliloquy_sliders() {

    $args = array(
        'post_type'   => 'soliloquy',
        'numberposts' => -1,
    );

    $posts = get_posts( $args );

    $post_options = array();
    if ( $posts ) {
        foreach ( $posts as $post ) {
          $post_options[ $post->ID ] = $post->post_title;
        }
    }

    return $post_options;
}

function dxl_soliloquy_field( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$soliloquys = cmb2_get_soliloquy_sliders();

	$options = $field_type_object->select_option( array(
		'label' => __( '--- None ---', 'cmb2' ),
		'value' => '',
		'checked' => true
	) );

	foreach ( $soliloquys as $id => $soliloquy ) {
		$options .= $field_type_object->select_option( array(
			'label'   => $soliloquy,
			'value'   => $id,
			'checked' => $escaped_value == $id,
		) );
	}


	echo $field_type_object->select( array( 'options' => $options, 'width' => 200 ) );
}
add_action( 'cmb2_render_soliloquy', 'dxl_soliloquy_field', 10, 5 );

add_action( 'cmb2_init', 'dxl_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function dxl_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_dxl_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'header',
		'title'         => __( 'Page Header', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Page Slider', 'cmb2' ),
		'desc' => __( 'Select the Soliloquy slider to display on this page.', 'cmb2' ),
		'id'   => $prefix . 'page_slider',
		'type' => 'soliloquy',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Page Title', 'cmb2' ),
		'desc' => __( 'Do you want to display the title in the page header?', 'cmb2' ),
		'id'   => $prefix . 'page_title',
		'type' => 'checkbox',
	) );
}

add_action( 'cmb2_init', 'dxl_register_about_page_metabox' );
function dxl_register_about_page_metabox() {

}

add_action( 'cmb2_init', 'dxl_register_repeatable_group_field_metabox' );
function dxl_register_repeatable_group_field_metabox() {

}

add_action( 'cmb2_init', 'dxl_register_user_profile_metabox' );
function dxl_register_user_profile_metabox() {

}

add_action( 'cmb2_init', 'dxl_register_theme_options_metabox' );
function dxl_register_theme_options_metabox() {

}
