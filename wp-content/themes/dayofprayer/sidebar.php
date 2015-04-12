<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package dxl
 */

?>

<div id="secondary" class="widget-area" role="complementary">

<?php
	if( is_archive() ) {
		dynamic_sidebar( 'blog-sidebar' );
	}else {
		dynamic_sidebar( 'sidebar-1' );
	}
?>

</div><!-- #secondary -->
