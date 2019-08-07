<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package caozhuti
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="<?php echo _cao('site_favicon') ?>" rel="icon">
    <title><?php echo _title() ?></title>
	<?php wp_head(); ?>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>

<div class="site">
    <?php
        get_template_part( 'parts/navbar' );

        if ( is_archive() || is_search() || is_page_template() ) {
          get_template_part( 'parts/term-bar' );
        }
        
    ?>
    
    <div class="site-content">
    
