<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dxl
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="shortcut icon" href="<?php print home_url(); ?>/favicon.png"> 
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'feather_menu' ); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'dxl' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="container relative">
			<div class="row">
				<div class="col-sm-6">
					<div class="site-branding">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="dop-home">
							<img src="<?php print get_template_directory_uri(); ?>/images/EEDOP_2015_Logo.png" class="dop-logo" alt="<?php bloginfo( 'name' ); ?>" />
						</a>
					</div><!-- .site-branding -->
				</div>
				<div class="col-sm-6">
					<div class="right-box pull-right">
						<div class="social-icons pull-right">
							<a href="https://twitter.com/search?f=realtime&q=%23PrayEERU" target="_blank" class="social-icon eedop-twitter"></a>
							<a href="https://www.facebook.com/SLMConnect" target="_blank" class="social-icon eedop-facebook"></a>
							<a href="#" class="social-icon eedop-email"></a>
						</div>
						<h4 class="pull-right"><?php _e( 'SPREAD THE WORD' ); ?></h4>
					</div>
				</div>
			</div>
		</div><!-- .container -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
