<?php
/*
Plugin Name: Story Latest
Plugin URI: http://philipjohn.co.uk/category/plugins/story-latest
Description: Easily group posts from the same story together, and display them on each post
Version: 0.2
Author: Philip John
Author URI: http://philipjohn.co.uk
Text Domain: story-latest
*/

// Stop the file being called directly
if (!function_exists('add_action')){
	_e("Oh. Hello. I think you might be in the wrong place. There's nothing for you here.", 'story-latest');
	exit;
}

function pj_sl_shortcode($atts){
	extract(shortcode_atts(array(
	      'tag' => 'foo',
	      'title' => __('Latest updates on this story', 'story-latest'),
	      'container_id' => 'story-latest'
	), $atts));
	
	$the_query = new WP_Query( 'tag='.$tag );
	
	if ($the_query->have_posts()){
	
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$content .= '<li><a href="'.get_permalink().'">'.get_the_title().'</li>';
		endwhile;
	
		// Reset Post Data
		wp_reset_postdata();
		
		return '<div id="'.$container_id.'"><h3>'.$title.':</h3><ul>'.$content.'</ul></div>';
	}
}
add_shortcode('story-latest', 'pj_sl_shortcode');

?>
