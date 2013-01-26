<?php
/*
Plugin Name: Story Latest
Plugin URI: http://philipjohn.co.uk/category/plugins/story-latest
Description: Easily place links to the latest posts on a story below each post
Version: 0.1
Author: Philip John
Author URI: http://philipjohn.co.uk
*/

// Stop the file being called directly
if (!function_exists('add_action')){
	echo "Oh. Hello. I think you might be in the wrong place. There's nothing for you here.";
	exit;
}

// Detect install location
if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
	$pj_sl_location = 'mu-plugins';
	$pj_sl_plugin_dir = WPMU_PLUGIN_DIR . '/';
	$pj_sl_plugin_url = WPMU_PLUGIN_URL . '/';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/story-latest/' . basename(__FILE__))) {
	$pj_sl_location = 'subfolder-plugins';
	$pj_sl_plugin_dir = WP_PLUGIN_DIR . '/story-latest/';
	$pj_sl_plugin_url = WP_PLUGIN_URL . '/story-latest/';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
	$pj_sl_location = 'plugins';
	$pj_sl_plugin_dir = WP_PLUGIN_DIR . '/';
	$pj_sl_plugin_url = WP_PLUGIN_URL . '/';
} else {
	wp_die(__('There was an issue determining where the plugin is installed. Please reinstall.', 'mp'));
}

function pj_sl_shortcode($atts){
	extract(shortcode_atts(array(
	      'tag' => 'foo'
	), $atts));
	
	$the_query = new WP_Query( 'tag='.$tag );
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
		$content .= '<li><a href="'.get_permalink().'">'.get_the_title().'</li>';
	endwhile;

	// Reset Post Data
	wp_reset_postdata();
	
	return (current_user_can('manage-options')) ? '<div id="story-latest"><h3>Latest updates on this story:</h3><ul>'.$content.'</ul></div>' : '';
}
add_shortcode('story-latest', 'pj_sl_shortcode');

?>
