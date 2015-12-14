<?php
/*
Template Name: doconline
*/
/****************************************************************************************************/
/* Pantalla: doconline.php
/* Theme: doconline
/* Descripción: template para la página de documentación on-line
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		05/03/2012	Creación               
/*
/****************************************************************************************************/

// constantes
if(!defined('RCOUNT')) define('RCOUNT',10);

include(WP_CONTENT_DIR.'/plugins/doconline/class/util.class.php');
include(WP_CONTENT_DIR.'/plugins/doconline/class/datos.class.php');
include(WP_CONTENT_DIR.'/plugins/doconline/class/campos.class.php');

// Obtenemos el usuario identificado:
$userData = NULL;
$documentos = NULL;
if(is_user_logged_in()) {
	global $current_user;
	get_currentuserinfo();
	$userData = array (
		'id' => $current_user->ID,
		'nombre' => $current_user->display_name,
		'rol' => get_current_user_role(),
	);
}

// Acciones
$mensajes = array();
include('_acciones.php');

// DCS a 05/03/2012
if(!defined('NTHEME')) define('NTHEME','twentyeleven-child');

$pFlags = array(); // para ventanas mostrables
/*
$myPath = dirname(__FILE__);
$myUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$myPath = substr($myPath,0,strpos($myPath,'wp-content')+11);
$myUrl = substr($myUrl,0,strpos($myUrl,'wp-content')+11);
*/
?>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
	<title>
	<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
	wp_title( '|', true, 'right' );
	// Add the blog name.
	bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
	?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!-- Añadido por DCS a 05/03/2013 para gestionar el módulo de documentación online -->
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/doconline.css" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )	wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	?>
	<!-- JQuery -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jquery-ui.min.js"></script>
	<link type="text/css" href="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
	<!-- JSColor -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscolor/jscolor.js"></script>
	<!-- Modal -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/simplemodal/jquery.simplemodal.1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/simplemodal/basic/js/basic.js"></script>
	<!-- BASIC Style CSS files -->
	<link type='text/css' href='<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/simplemodal/basic/css/basic.css' rel='stylesheet' media='screen' />
	<!-- Calendario -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscal/src/js/jscal2.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscal/src/js/lang/es.js"></script>
	<link type='text/css' href='<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscal/src/css/jscal2.css' rel='stylesheet' media='screen' />
	<link type='text/css' href='<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscal/src/css/border-radius.css' rel='stylesheet' media='screen' />
	<link type='text/css' href='<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/jscal/src/css/steel/steel.css' rel='stylesheet' media='screen' />
	<!-- JS Principal -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/main.js"></script>
	<!-- Draggable -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/ui/jquery.ui.draggable.js"></script>
	<!-- wysiwyg -->
	<script type="text/javascript" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/tinyMCE/tiny_mce.js"></script>
	
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" role="banner">
		<hgroup>
			<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		<?php
			// Check to see if the header image has been removed
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) :
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
				// The header image
				// Check if this is a post or page, if it has a thumbnail, and if it's a big one
				if ( is_singular() &&
						has_post_thumbnail( $post->ID ) &&
						( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( HEADER_IMAGE_WIDTH, HEADER_IMAGE_WIDTH ) ) ) &&
						$image[1] >= HEADER_IMAGE_WIDTH ) :
					// Houston, we have a new header image!
					echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
				else : ?>
				<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
			<?php endif; // end check for featured image or standard header ?>
		</a>
		<?php endif; // end check for removed header image ?>

		<?php
			// Has the text been hidden?
			if ( 'blank' == get_header_textcolor() ) :
		?>
			<div class="only-search<?php if ( ! empty( $header_image ) ) : ?> with-image<?php endif; ?>">
			<?php get_search_form(); ?>
			</div>
		<?php
			else :
		?>
			<?php get_search_form(); ?>
		<?php endif; ?>

		<nav id="access" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
			<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
			<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
			<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
			<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assiged to the primary position is the one used. If none is assigned, the menu with the lowest ID is used. */ ?>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			<div class="menu">
				<ul>
					<li><a href="<?php bloginfo('url'); ?>/wiki/" title="Wiki">Wiki</a></li>
				</ul>
			</div>
		</nav><!-- #access -->
	</header><!-- #branding -->

	<div id="main">
		<?php if(!is_array($userData)) { ?>
		<div class="panel-aviso">
			<p>Para acceder a esta página ha de estar identificado.</p>
			<p>No dude en <a href="<?php bloginfo('url'); ?>/wp-login.php?action=register">registrarse</a> para ganar todas las ventajas de DocOnline.</p>
		</div>
		<?php } else { ?>
		<div class="panel-aviso">
			<p>Estás identificado como <?php echo $userData['nombre']; ?> con ID <?php echo $userData['id']; ?> y rol <?php echo $userData['rol']; ?>.</p>
		</div>
		<?php
		if(is_array($mensajes) && count($mensajes) > 0) foreach($mensajes as $mensaje) echo '<div class="panel-aviso"><p>'.$mensaje.'</p></div>';
		?>
		<?php include('mainDoconline.php'); ?>
		<?php } ?>
		<div id="pie-doconline">
		PIE DOCONLINE
		</div>
	</div>
	

</body>
</html>