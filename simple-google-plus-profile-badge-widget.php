<?php
/* Plugin Name: Simple Google Plus Profile Badge Widget
Plugin URI: http://wordpress.org/plugins/simple-google-plus-profile-badge-widget/
Description: This plugin allows you to set new Google Plus Profile Badge Widget to your WordPress site.
Version: 1.0
Author: MonjurulHoque
Author URI: http://monjurulhoque.com
*/

add_action('widgets_init', 'simple_googleplus_load_widgets');

function simple_googleplus_load_widgets()
{
	register_widget('mon_googleplus_load_widgets');
}

add_action( 'plugins_loaded', 'new_google_plus_badge_widget_load_textdomain' );
function new_google_plus_badge_widget_load_textdomain() {
  load_plugin_textdomain( 'simple-google-plus-badge-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

class mon_googleplus_load_widgets extends WP_Widget {
	
	function __construct()
	{
		$widget_ops = array('classname' => 'mon_googleplus', 'description' => __('Adds a Simple Google Plus badge widget.','simple-google-plus-badge-widget'));

		$control_ops = array('id_base' => 'google-badge-box');

		parent::__construct('google-badge-box', __('Simple Google Plus Badge Box','simple-google-plus-badge-widget'), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);		
		$page_type = $instance['page_type'];
		$page_url = $instance['page_url'];
		$width = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$gp_layout = $instance['gp_layout'];
		$cover_photo = isset($instance['cover_photo']) ? 'true' : 'false';
		$tagline = isset($instance['tagline']) ? 'true' : 'false';
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($page_url): ?>
			<script src="https://apis.google.com/js/platform.js" async defer></script>
			<div <?php if($page_type == 'profile') { ?>class="g-person"<?php } elseif($page_type == 'page') { ?>class="g-page"<?php } elseif($page_type == 'community') { ?>class="g-community"<?php } ?> data-width="<?php echo $width; ?>" data-href="<?php echo $page_url; ?>" data-layout="<?php echo $gp_layout; ?>" data-theme="<?php echo $color_scheme; ?>" data-rel="publisher" data-showtagline="<?php echo $tagline; ?>" data-showcoverphoto="<?php echo $cover_photo; ?>"></div>
		<?php endif;
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page_type'] = $new_instance['page_type'];
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['gp_layout'] = $new_instance['gp_layout'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['cover_photo'] = $new_instance['cover_photo'];
		$instance['tagline'] = $new_instance['tagline'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => __('Find us on Google Plus','simple-google-plus-badge-widget'), 'page_url' => '', 'width' => '300', 'color_scheme' => 'light', 'gp_layout' => 'portrait', 'page_type' => 'profile', 'cover_photo' => true, 'tagline' => true);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('page_type'); ?>"><?php _e('Page type','simple-google-plus-badge-widget'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('page_type'); ?>" name="<?php echo $this->get_field_name('page_type'); ?>" style="width:100%;">
				<option <?php if ('profile' == $instance['page_type']) echo 'selected="selected"'; ?>>profile</option>
				<option <?php if ('page' == $instance['page_type']) echo 'selected="selected"'; ?>>page</option>
				<option <?php if ('community' == $instance['page_type']) echo 'selected="selected"'; ?>>community</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','simple-google-plus-badge-widget'); ?>:</label>
			<input type="text" class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e('Google+ Page URL','simple-google-plus-badge-widget'); ?>:</label>
			<input type="text" class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width','simple-google-plus-badge-widget'); ?>:</label>
			<input type="text" class="widefat" style="width: 50px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e('Color Scheme','simple-google-plus-badge-widget'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" style="width:100%;">
				<option <?php if ('light' == $instance['color_scheme']) echo 'selected="selected"'; ?>>light</option>
				<option <?php if ('dark' == $instance['color_scheme']) echo 'selected="selected"'; ?>>dark</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('gp_layout'); ?>"><?php _e('Layout','simple-google-plus-badge-widget'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('gp_layout'); ?>" name="<?php echo $this->get_field_name('gp_layout'); ?>" style="width:100%;">
				<option <?php if ('portrait' == $instance['gp_layout']) echo 'selected="selected"'; ?>>portrait</option>
				<option <?php if ('landscape' == $instance['gp_layout']) echo 'selected="selected"'; ?>>landscape</option>
			</select>
		</p>
		
		<p>
			<b><?php _e('Portrait Layout Settings','simple-google-plus-badge-widget'); ?></b>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['cover_photo'], 'on'); ?> id="<?php echo $this->get_field_id('cover_photo'); ?>" name="<?php echo $this->get_field_name('cover_photo'); ?>" /> 
			<label for="<?php echo $this->get_field_id('cover_photo'); ?>"><?php _e('Cover Photo','simple-google-plus-badge-widget'); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['tagline'], 'on'); ?> id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $this->get_field_name('tagline'); ?>" /> 
			<label for="<?php echo $this->get_field_id('tagline'); ?>"><?php _e('Tagline','simple-google-plus-badge-widget'); ?></label>
		</p>
		<p align="center">		
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="G7YTKMJYS4T92">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		</p>

	<?php
	}
}

?>