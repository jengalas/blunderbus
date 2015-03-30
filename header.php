<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Blunderbus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

<nav class="site-navigation">
	<div class="navbar navbar-default">
		<div class="navbar-header">
			<!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only"><?php _e('Toggle navigation','blunderbus') ?> </span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>

			<!-- Your site title as branding in the menu -->
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	    </div>
										
		<!-- The WordPress Menu goes here -->
		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'depth'             => 2,
				'container'         => 'div',
				'container_class' => 'collapse navbar-collapse',
				'menu_class' => 'nav navbar-nav',
				'fallback_cb' 		=> 'wp_bootstrap_navwalker::fallback',
				'menu_id' => 'main-menu',
				'walker' => new wp_bootstrap_navwalker()
			)
		); ?>
					
	</div><!-- .navbar -->
</nav><!-- .site-navigation -->

<header id="masthead" class="site-header" role="banner" style="background-image: url('<?php header_image(); ?>')"><span></span></header><!-- #masthead -->

<div class="main-content">
	<div class="container">
		<div class="row">
			<?php 
			if ( is_page_template('grandcanyonsurvey-page.php')) {
			    echo '<div id="content" class="main-content-inner col-sm-12 col-md-8">';
			} else if ( is_page_template('triangulationmanual-page.php')) {
				  echo '<div id="content" class="main-content-inner col-sm-12 col-md-8">';
			} else {
			    echo '<div id="content" class="main-content-inner col-sm-12">';
			} ?>