<?php
/**
 * dxl functions and definitions
 *
 * @package dxl
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

require_once 'config.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if ( ! function_exists( 'dxl_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dxl_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on dxl, use a find and replace
	 * to change 'dxl' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'dxl', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_image_size( '560x280', 560, 280, true );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dxl' ),
		'secondary' => __( 'Secondary Menu', 'dxl' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dxl_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // dxl_setup
add_action( 'after_setup_theme', 'dxl_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function dxl_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dxl' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'dxl' ),
		'id'            => 'blog-sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	) );

	register_sidebars( 4, array(
		'name'          => __('Footer Area %d'),
	    'id'            => 'footer-sidebar',          
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>' 
	) );
}
add_action( 'widgets_init', 'dxl_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dxl_scripts() {
	wp_enqueue_style( 'dop-layout', get_stylesheet_directory_uri() . '/css/layout.css' );
	wp_enqueue_style( 'oswald-font', get_stylesheet_directory_uri() . '/fonts/oswald/oswald.css' );
	wp_enqueue_style( 'eedop-icons', get_stylesheet_directory_uri() . '/fonts/eedop/eedop.css' );
	wp_enqueue_style( 'museoslab', get_stylesheet_directory_uri() . '/fonts/museoslab/museoslab.css' );
	wp_enqueue_style( 'ubuntu', 'http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' );
	wp_enqueue_style( 'content', get_stylesheet_directory_uri() . '/css/content.css' );
	wp_enqueue_style( 'dop-style', get_stylesheet_uri() );

	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ), '1', true );
}
add_action( 'wp_enqueue_scripts', 'dxl_scripts' );


function my_enqueue( $hook ) {
    wp_enqueue_style( 'admin', get_stylesheet_directory_uri() . '/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );



function add_infoselect_field( $field_groups ) {
	foreach( $field_groups as &$group ){
		if( $group["name"] == "advanced_fields" ){ // to add to the Advanced Fields
			//if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
			//if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
			$group["fields"][] = array(
				"class"=>"button",
				"value" => __("Info Select", "gravityforms"),
				"onclick" => "StartAddField('infoselect');"
			);

			break;
		}
	}
	return $field_groups;
}
add_filter( 'gform_add_field_buttons', 'add_infoselect_field' );

function ichoice_value_match( $field, $choice, $value ) {
	$choice_value = GFFormsModel::maybe_trim_input( $choice['title'], $field->formId, $field );
	$value        = GFFormsModel::maybe_trim_input( $value, $field->formId, $field );
	if ( $choice_value == $value ) {
		return true;
	} else if ( $field->enablePrice ) {
		$ary   = explode( '|', $value );
		$val   = count( $ary ) > 0 ? $ary[0] : '';
		$price = count( $ary ) > 1 ? $ary[1] : '';

		if ( $val == $choice['title'] ) {
			return true;
		}
	} // add support for prepopulating multiselects @alex
	else if ( RGFormsModel::get_input_type( $field ) == 'multiselect' ) {
		$values = explode( ',', $value );
		if ( in_array( $choice_value, $values ) ) {
			return true;
		}
	}

	return false;
}

// Adds title to GF custom field
add_filter( 'gform_field_type_title' , 'wps_infoselect_title' );
function wps_infoselect_title( $type ) {
	if ( $type == 'infoselect' )
		return __( 'Info Select' , 'gravityforms' );
}

// Adds the input area to the external side
add_action( "gform_field_input" , "wps_infoselect_field_input", 10, 5 );
function wps_infoselect_field_input ( $input, $field, $value = '', $lead_id, $form_id ){
	if ( $field["type"] == "infoselect" ) {

		$max_chars = "";
		if( !IS_ADMIN && !empty( $field["maxLength"] ) && is_numeric( $field["maxLength"] ) )
			$max_chars = self::get_counter_script( $form_id, $field_id, $field["maxLength"] );

		$input_name = $form_id .'_' . $field["id"];
		$tabindex = GFCommon::get_tabindex();
		$css = isset( $field['cssClass'] ) ? $field['cssClass'] : "";

		$IChoices = $field->ichoices; 

		$html = '<div class="ginput_container">';
		$html .= '<div class="ichoices_wrapper">';
		$html .= '<ul class="gfield_infoselect" id="input_' . $form_id . '_' . $field['id'] . '">';

		foreach( $IChoices as $index => $choice ) {

			$choice_id = $form_id . '_' . $field['id'] . '_' . $index;

			$checked = ichoice_value_match( $field, $choice, $value ) ? "checked='checked'" : '';;

			$html .= '<li class="ichoice gichoice_' . $choice_id . '">';
			//$html .= '<div class="choice_image">';
			//$html .= '<img src="' . $choice['image'] . '" />';
			//$html .= '</div>';
			$html .= '<h2 class="choice-title">' . $choice['title'] . '</h2>';
			$html .= '<div class="choice-footer">';
			$html .= '<input type="radio" ' . $checked . ' name="input_' . $field['id'] . '" id="' . $choice_id . '" value="' . $choice['title'] . '" />';
			$html .= '<label for="' . $choice_id . '"><span>Select</span>';
			$html .=  apply_filters( 'gform_after_field', '', $field['id'], $field['id'], sanitize_title_for_query( $choice['title'] ) );
			$html .= '</label>';
			$html .= '</div>';
			$html .= '</li>';

		}

		$html .= "</ul>";
		$html .= "</div>";
		$html .= "</div>";
		
		return $html;
	}

	return '';
}
// Now we execute some javascript technicalitites for the field to load correctly
add_action( "gform_editor_js", "wps_gform_editor_js" );
function wps_gform_editor_js(){ ?>
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
	//Add all textarea settings to the "infoselect" field plus custom "infoselect_setting"
	// fieldSettings["infoselect"] = fieldSettings["textarea"] + ", .infoselect_setting"; // this will show all fields that Paragraph Text field shows plus my custom setting
	// from forms.js; can add custom "infoselect_setting" as well
	fieldSettings["infoselect"] = ".label_setting, .description_setting, .admin_label_setting, .size_setting, .default_value_textarea_setting, .error_message_setting, .css_class_setting, .visibility_setting, .infoselect_setting"; //this will show all the fields of the Paragraph Text field minus a couple that I didn't want to appear.
	//binding to the load field settings event to initialize the checkbox
	$(document).bind("gform_load_field_settings", function(event, field, form){
	jQuery("#field_infoselect").attr("checked", field["field_infoselect"] == true);
	$("#field_infoselect_value").val(field["infoselect"]);
	});
	});
	</script>
	<?php
}
// Add a custom setting to the infoselect advanced field
add_action( "gform_field_standard_settings" , "wps_infoselect_settings" , 10, 2 );
function wps_infoselect_settings( $position, $form_id ){
	// Create settings on position 50 (right after Field Label)
	if( $position == 50 ){
	?>
	<li class="infoselect_setting field_setting">
		<ul id="field_ichoices" class="infoselect_fields"></ul>
	<label for="field_infoselect" class="inline">
	<?php _e("Disable Submit Button", "gravityforms"); ?>
	<?php gform_tooltip("form_field_infoselect"); ?>
	</label>
	<script>

	jQuery(document).bind('gform_load_field_settings', function(event, field) {
        if( field.type == 'infoselect' ) {
            LoadFieldIChoices( field );
        }
    });

    

	/**
	 * Locally updates the JS form variable with the newly inputed values
	 * 
	 * @param string inputType 
	 * @param int index  The current setting field index
	 */
	function SetIChoice(inputType, index){
	    var title = jQuery("#" + inputType + "_choice_title_" + index).val();
	    var image = jQuery("#" + inputType + "_choice_image_" + index).val();
	    var desc = jQuery("#" + inputType + "_choice_desc_" + index).val();

	    field = GetSelectedField();

	    field.ichoices[index].title = title;
	    field.ichoices[index].image = image;
	    field.ichoices[index].desc = desc;

	    LoadBulkChoices(field);
	}

	/**
	 * The actual function that calls 
	 * 
	 * @param {[type]} index [description]
	 */
	function InsertInfoSelectChoice(index) {
	    var field = GetSelectedField();

	    var newIChoice = new IChoice("", "", "");

	    field.ichoices.splice( index, 0, newIChoice );
	    LoadFieldIChoices( field );
	    //UpdateInfoSelectChoices(GetInputType(field));
	}


	function DeleteInfoSelectChoice(index){
	    var field = GetSelectedField();

	    field.ichoices.splice(index, 1);
	    LoadFieldIChoices(field);
	}
	

	/**
	 * The HTML output for a single info field in the backend
	 * Includes the add / remove buttons
	 * 
	 * @param object field 
	 * @return string
	 */
	function GetIFieldChoices(field) {
		if (field.ichoices == undefined)
			return "";

		var str = "";
		for (var i = 0; i < field.ichoices.length; i++) {
			var inputType = GetInputType(field);

			str += "<li class='field-ichoice-row' data-input_type='" + inputType + "' data-index='" + i + "'>";
			str += "<i class='fa fa-sort field-ichoice-handle'></i> ";
			str += "<div class='ifield-container'>";
			str += "<input type='text' id='" + inputType + "_choice_title_" + i + "' value=\"" + field.ichoices[i].title.replace(/"/g, "&quot;") + "\" class='ifield-choice-title field-choice-input' placeholder='Title' />";
			str += "<input type='text' id='" + inputType + "_choice_image_" + i + "' value=\"" + field.ichoices[i].image.replace(/"/g, "&quot;") + "\" class='ifield-choice-image field-choice-input' placeholder='Image' />";
			str += "<textarea id='" + inputType + "_choice_desc_" + i + "' class='ifield-choice-desc field-choice-input' placeholder='Description'>" + field.ichoices[i].desc.replace(/"/g, "&quot;") + "</textarea>";
			str += "</div>";

			if (window["gform_append_field_choice_option_" + field.type])
				str += window["gform_append_field_choice_option_" + field.type](field, i);

			str += gform.applyFilters('gform_append_field_choice_option', '', field, i);

			str += "<a class='gf_insert_field_choice' onclick=\"InsertInfoSelectChoice(" + (i + 1) + ");\"><i class='gficon-add'></i></a>";


			if (field.ichoices.length > 1)
				str += "<a class='gf_delete_field_choice' onclick=\"DeleteInfoSelectChoice(" + i + ");\"><i class='gficon-subtract'></i></a>";

			str += "</li>";

		}
		return str;
	}


	/**
	 * Handles new IChoices when added via splice in InsertInfoSelectChoice()
	 * Handles events on new IChoices
	 * 
	 * @param {[type]} field [description]
	 */
	function LoadFieldIChoices(field){
	    jQuery("#field_ichoices").html( GetIFieldChoices( field ) );

	    jQuery(document).trigger('gform_load_field_choices', [field]);

	    /**
	     * Watch for updates on field values and update accordingly
	     */
	    jQuery('#field_ichoices').on('input propertychange', '.field-choice-input', function(e){
	    	var $this = jQuery(this);
			var li = $this.closest('.field-ichoice-row');
			var inputType = li.data('input_type');
			var i = li.data('index');

			SetIChoice( inputType, i );
		});

	    gform.doAction('gform_load_field_choices', [field]);
	}


	/**
	 * Defines new IChoice object
	 *
	 * See gravityforms/js/forms.js for reference
	 * 
	 * @param string title
	 * @param string image
	 * @param string desc
	 */
	function IChoice(title, image, desc){
	    this.isSelected = false;
	    this.title = title ? title : "";
	    this.image = image ? image : "";
	    this.desc = desc ? desc : "";
	}

	</script>
	</li>
	<?php
	}
}

//Filter to add a new tooltip
add_filter('gform_tooltips', 'wps_add_infoselect_tooltips');
function wps_add_infoselect_tooltips($tooltips){
	$tooltips["form_field_infoselect"] = "<h6>Disable Submit Button</h6>Check the box if you would like to disable the submit button.";
	$tooltips["form_field_default_value"] = "<h6>Default Value</h6>Enter the Info Select here.";
	return $tooltips;
	}
	// Add a script to the display of the particular form only if infoselect field is being used
	add_action( 'gform_enqueue_scripts' , 'wps_gform_enqueue_scripts' , 10 , 2 );
	function wps_gform_enqueue_scripts( $form, $ajax ) {
	// cycle through fields to see if infoselect is being used
	foreach ( $form['fields'] as $field ) {
	if ( ( $field['type'] == 'infoselect' ) && ( isset( $field['field_infoselect'] ) ) ) {
	$url = plugins_url( 'gform_infoselect.js' , __FILE__ );
	wp_enqueue_script( "gform_infoselect_script", $url , array("jquery"), '1.0' );
	break;
	}
	}
}
// Add a custom class to the field li
add_action("gform_field_css_class", "custom_class", 10, 3);
function custom_class($classes, $field, $form){
	if( $field["type"] == "infoselect" ){
	$classes .= " gfield_infoselect_li";
	}
	return $classes;
}

function infoselect_default() { ?>

	case "infoselect" :

	if (!field.label)
		field.label = "<?php _e( 'Untitled', 'gravityforms' ); ?>";

	field.inputs = null;
	if (!field.ichoices) {
		field.ichoices = new Array(new IChoice("<?php _e( 'Title', 'gravityforms' ); ?>", "", ""));
	}

<?php
}

add_action( 'gform_editor_js_set_default_values', 'infoselect_default' );

/**
 * Replaces the template variable with the new value
 * 
 * Passed by reference
 * 
 * @param type &$template 
 * @param type $var 
 * @param type $value 
 * @return type
 */
function template_var( &$template, $var, $value ) {
	if( $template = str_replace( $var, $value, $template ) )
		return true;

	return false;
}

/**
 * Grabs the email template to be sent upon form submission
 * 
 * Replaces the template variables with appropriate data from
 * the form and lead
 * 
 * @param type $lead 
 * @param type $form 
 * @return type
 */
function after_submission( $lead, $form ) {
	global $redux;

	if( $lead['form_id'] != 1 )
		return;

	$email = $lead['11'];
	$times = array();
	$city = '';
	$country = $lead['4'];

	foreach( $lead as $field => $value ) {
		if( empty( $city ) && in_array( $field, array( 13, 17, 19, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 42, 44, 46, 48, 50 ) ) ) {
			if( isset( $value ) && ! empty( $value ) ) {
				$city = $lead[$field];
			}
		}

		if( preg_match( '/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $value ) ) {
			$times[] = $value;
		}
	}

	if( empty( $city ) )
		return false;

	foreach( $form['fields'] as $id => $field ) {
		if( ! isset( $field->ichoices ) )
			continue;

		foreach( $field->ichoices as $key => $c ) {
			if( $c['title'] == $city ) {
				$image = $c['image'];
				break;
			}
		}

		if( isset( $image ) )
			break;
	}

	
	$email_template = @file_get_contents( __DIR__ . '/emails/dop-confirmation.html' );

	if( ! $email_template || empty( $email_template ) )
		return false;

	if( empty( $times ) ) {
		$times = 'Any Time!';
	}else {
		$times = implode( ', ', $times );
	}

	if( empty( $image ) ) {
		$image = '<p>&nbsp;</p>';
	}else {
		$image = '<p><img src="http://digitaldayofprayer.org/wp-content/themes/dayofprayer/images/cities/' . $image . '"></p>';
	}

	@template_var( $email_template, '{FIELD_IMAGE}', $image );
	@template_var( $email_template, '{FIELD_CITY}', $city );
	@template_var( $email_template, '{FIELD_COUNTRY}', $country );
	@template_var( $email_template, '{FIELD_TIMES}', $times );

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	if( is_email( $email ) ) {
		$send = wp_mail( $email, $redux['email_subject'], $email_template, $headers );
	}
	
}
add_action( 'gform_after_submission', 'after_submission', 15, 2 );


/**
 * Change the loading spinner
 * 
 * @param type $image_src 
 * @param type $form 
 * @return type
 */
function spinner_url( $image_src, $form ){
    return get_stylesheet_directory_uri() . '/images/gf/spinner.gif';
}
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );


/**
 * Displays the number of entries for a particular checkbox / radio
 * 
 * @param html $choice_markup 
 * @param array $choice 
 * @param object $this 
 * @param string $value 
 * @return string
 */
function entry_count( $choice_markup, $choice, $this, $value ) {
	global $wpdb;

	$insert_pos = strpos( $choice_markup, '</li>' );

	// Field ID to search for
	$choice_number = preg_match( '/\<input name\=[\']input_([^\']+)/', $choice_markup, $choices );

	// Everything up until the ending <li> tag
	$before = substr( $choice_markup, 0, $insert_pos );

	// Ending </li> tag 
	$after = substr( $choice_markup, $insert_pos );

	$input_id = isset( $choices[1] ) ? $choices[1] : 0;
	$choice_value = isset( $choice['value'] ) ? $choice['value'] : '';

	$count = '';
	$query = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . "rg_lead_detail " .
						   "WHERE form_id=1 
						   AND field_number LIKE $input_id
						   AND value='$choice_value'", 'ARRAY_A' );

	if( is_array( $query ) )
		$count = '<span class="count">' . count( $query ) . '</span>';


	return $before . $count .  $after;
}
add_filter( 'gform_field_choice_markup_pre_render_1', 'entry_count', 10, 4 );
