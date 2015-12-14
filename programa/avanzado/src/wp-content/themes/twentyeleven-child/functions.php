<?php
/*
	Theme Name: twentyeleven-child
	Theme URI: www.digital5.es
	Version: 1.0
	Author: David Calvo
*/

// Activo session_start
if ( !session_id() ) add_action( 'init', 'session_start' );

function remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) $end = strpos($link, '"',$offset);
	if ($end) $link = substr_replace($link, '', $offset, $end-$offset);
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');
add_filter( 'show_admin_bar', '__return_false' );

/*
Plugin Name: Limit Posts
Plugin URI: http://labitacora.net/comunBlog/limit-post.phps
Description: Limits the displayed text length on the index page entries and generates a link to a page to read the full content if its bigger than the selected maximum length. 
Usage: the_content_limit($max_charaters, $more_link)
Version: 1.1
Author: Alfonso Sanchez-Paus Diaz y Julian Simon de Castro
Author URI: http://labitacora.net/
License: GPL
Download URL: http://labitacora.net/comunBlog/limit-post.phps
Make: 
    In file index.php 
    replace the_content() 
    with the_content_limit(1000, "more")
*/
function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

   if (strlen($_GET['p']) > 0) {
      echo $content;
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo $content;
        echo "&nbsp;<a href='";
        the_permalink();
        echo "' title='".$more_link_text."'>"."..."."</a>";
        /*
				echo "<br/>";
        echo "<a href='";
        the_permalink();
        echo "'>".$more_link_text."</a></p>";
				*/
				echo "</p>";
   }
   else {
      echo $content;
   }
}

/**
 * Returns the translated role of the current user. If that user has
 * no role for the current blog, it returns false.
 *
 * @return string The name of the current role
 **/
function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? $wp_roles->role_names[$role] : false;
}

