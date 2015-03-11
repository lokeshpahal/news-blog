<?php
//Hook Widget
add_action( 'widgets_init', 'google_ads_master_widget_viral' );
//Register Widget
function google_ads_master_widget_viral() {
register_widget( 'google_ads_master_widget_viral' );
}

class google_ads_master_widget_viral extends WP_Widget {
	function google_ads_master_widget_viral() {
	$widget_ops = array( 'classname' => 'Google Ads Master Viral', 'description' => __('This Widget turns your Wordpress "virulent" by allowing people to +1 and Share your pages. Watch those visits explode and greatly boost your google ads clicks! ', 'google_ads_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'google_ads_master_widget_viral' );
	$this->WP_Widget( 'google_ads_master_widget_viral', __('Google Ads Master Viral', 'google_ads_master'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$google_ads_title = isset( $instance['google_ads_title'] ) ? $instance['google_ads_title'] :false;
		$google_ads_title_new = isset( $instance['google_ads_title_new'] ) ? $instance['google_ads_title_new'] :false;
		$googleadsspacer ="'";
		$show_google_plus = isset( $instance['show_google_plus'] ) ? $instance['show_google_plus'] :false;
		$google_plus_bubble = isset( $instance['google_plus_bubble'] ) ? $instance['google_plus_bubble'] :false;
		$show_google_share = isset( $instance['show_google_share'] ) ? $instance['show_google_share'] :false;
		$google_share_bubble = isset( $instance['google_share_bubble'] ) ? $instance['google_share_bubble'] :false;
		echo $before_widget;
		
		// Display the widget title
	if ( $google_ads_title ){
		if (empty ($google_ads_title_new)){
		$google_ads_title_new = get_option('google_ads_master_name');
		}
		echo $before_title . $google_ads_title_new . $after_title;
	}
	else{
	}

	//Display Google Plus
	if ( $show_google_plus ){
		//Prepare Google Plus Bubble Count
		if ( $google_plus_bubble ){
			$google_plus_bubble_create = '<div class="g-plusone"></div>';
		}
		else{
			$google_plus_bubble_create = '<div class="g-plusone" data-annotation="none" ></div>&nbsp;&nbsp;&nbsp;';
		}
	}
	else{
		$google_plus_bubble_create = false;
	}

	//Display Google Share
	if ( $show_google_share ){
		//Prepare Google Share Bubble Count
		if ( $google_share_bubble ){
			$google_share_bubble_create = '<div class="g-plus" data-action="share" data-annotation="bubble" data-height="24"></div>';
		}
		else{
			$google_share_bubble_create = '<div class="g-plus" data-action="share" data-annotation="none" data-height="24"></div>';
		}
	}
	else{
		$google_share_bubble_create = false;
	}

	echo '<div style="display:flex;">' .
		$google_plus_bubble_create . $google_share_bubble_create .
		'</div>' .
		'<script type="text/javascript">' .
		'(function() {' .
		'var po = document.createElement('.$googleadsspacer.'script'.$googleadsspacer.'); po.type = '.$googleadsspacer.'text/javascript'.$googleadsspacer.'; po.async = true;' .
		'po.src = '.$googleadsspacer.'https://apis.google.com/js/platform.js'.$googleadsspacer.';' .
		'var s = document.getElementsByTagName('.$googleadsspacer.'script'.$googleadsspacer.')[0]; s.parentNode.insertBefore(po, s);' .
		'})();' .
		'</script>' .
		$after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['google_ads_title'] = strip_tags( $new_instance['google_ads_title'] );
		$instance['google_ads_title_new'] = $new_instance['google_ads_title_new'];
		$instance['show_google_plus'] = $new_instance['show_google_plus'];
		$instance['google_plus_bubble'] = $new_instance['google_plus_bubble'];
		$instance['show_google_share'] = $new_instance['show_google_share'];
		$instance['google_share_bubble'] = $new_instance['google_share_bubble'];
		return $instance;
	}
	function form( $instance ) {
	//Set up some default widget settings.
	$defaults = array( 'google_ads_title_new' => __('Google Ads Master', 'google_ads_master'), 'google_ads_title' => true, 'google_ads_title_new' => false, 'show_google_plus' => false, 'google_plus_bubble' => false, 'show_google_share' => false, 'google_share_bubble' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<br>
		<b>Check the buttons to be displayed:</b>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['google_ads_title'], true ); ?> id="<?php echo $this->get_field_id( 'google_ads_title' ); ?>" name="<?php echo $this->get_field_name( 'google_ads_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'google_ads_title' ); ?>"><b><?php _e('Display Widget Title', 'google_ads_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'google_ads_title_new' ); ?>"><?php _e('Change Title:', 'google_ads_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'google_ads_title_new' ); ?>" name="<?php echo $this->get_field_name( 'google_ads_title_new' ); ?>" value="<?php echo $instance['google_ads_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_google_plus'], true ); ?> id="<?php echo $this->get_field_id( 'show_google_plus' ); ?>" name="<?php echo $this->get_field_name( 'show_google_plus' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_google_plus' ); ?>"><b><?php _e('Display Google Plus Button', 'google_ads_master'); ?></b></label>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['google_plus_bubble'], true ); ?> id="<?php echo $this->get_field_id( 'google_plus_bubble' ); ?>" name="<?php echo $this->get_field_name( 'google_plus_bubble' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'google_plus_bubble' ); ?>"><b><?php _e('Google Plus Bubble Count', 'google_ads_master'); ?></b></label>
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_google_share'], true ); ?> id="<?php echo $this->get_field_id( 'show_google_share' ); ?>" name="<?php echo $this->get_field_name( 'show_google_share' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_google_share' ); ?>"><b><?php _e('Display Google Share Button', 'google_ads_master'); ?></b></label>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['google_share_bubble'], true ); ?> id="<?php echo $this->get_field_id( 'google_share_bubble' ); ?>" name="<?php echo $this->get_field_name( 'google_share_bubble' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'google_share_bubble' ); ?>"><b><?php _e('Google Share Bubble Count', 'google_ads_master'); ?></b></label>
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
	&nbsp;
	<b>Google Ads Master Website</b>
	</p>
	<p><a class="button-secondary" href="http://wordpress.techgasp.com/google-ads-master/" target="_blank" title="Google Ads Master Info Page">Info Page</a> <a class="button-secondary" href="http://wordpress.techgasp.com/google-ads-master-documentation/" target="_blank" title="Google Ads Master Documentation">Documentation</a> <a class="button-primary" href="http://wordpress.techgasp.com/google-ads-master/" target="_blank" title="Visit Website">Get Add-ons</a></p>
	<?php
	}
 }
?>