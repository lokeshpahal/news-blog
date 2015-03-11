<?php
/**
Plugin Name: Google Ads Master
Plugin URI: http://wordpress.techgasp.com/google-ads-master/
Version: 4.3.7
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: google-ads-master
Description: Google Ads Master for wordpress is the professional plugin you need to generate income with your website.
License: GPL2 or later
*/
/*
Copyright 2013 TechGasp  (email : info@techgasp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('google_ads_master')) :
///////DEFINE ID//////
define('GOOGLE_ADS_MASTER_ID', 'google-ads-master');
///////DEFINE VERSION///////
define( 'google_ads_master_VERSION', '4.3.7' );
global $google_ads_master_version, $google_ads_master_name;
$google_ads_master_version = "4.3.7"; //for other pages
$google_ads_master_name = "Google Ads Master"; //pretty name
if( is_multisite() ) {
update_site_option( 'google_ads_master_installed_version', $google_ads_master_version );
update_site_option( 'google_ads_master_name', $google_ads_master_name );
}
else{
update_option( 'google_ads_master_installed_version', $google_ads_master_version );
update_option( 'google_ads_master_name', $google_ads_master_name );
}
// HOOK ADMIN
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-admin.php');
// HOOK ADMIN IN & UN SHORTCODE
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-admin-shortcodes.php');
// HOOK ADMIN WIDGETS
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-admin-widgets.php');
// HOOK ADMIN ADDONS
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-admin-addons.php');
// HOOK ADMIN UPDATER
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-admin-updater.php');
// HOOK WIDGET VIRAL
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-widget-viral.php');
// HOOK WIDGET ADS
require_once( dirname( __FILE__ ) . '/includes/google-ads-master-widget-ads.php');

class google_ads_master{
//REGISTER PLUGIN
public static function google_ads_master_register(){
register_setting(GOOGLE_ADS_MASTER_ID, 'tsm_quote');
}
public static function content_with_quote($content){
$quote = '<p>' . get_option('tsm_quote') . '</p>';
	return $content . $quote;
}
//SETTINGS LINK IN PLUGIN MANAGER
public static function google_ads_master_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/google-ads-master.php' ) ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=google-ads-master' ) . '">'.__( 'Settings' ).'</a>';
	}

	return $links;
}

public static function google_ads_master_updater_version_check(){
global $google_ads_master_version;
//CHECK NEW VERSION
$google_ads_master_slug = basename(dirname(__FILE__));
$current = get_site_transient( 'update_plugins' );
$google_ads_plugin_slug = $google_ads_master_slug.'/'.$google_ads_master_slug.'.php';
@$r = $current->response[ $google_ads_plugin_slug ];
if (empty($r)){
$r = false;
$google_ads_plugin_slug = false;
if( is_multisite() ) {
update_site_option( 'google_ads_master_newest_version', $google_ads_master_version );
}
else{
update_option( 'google_ads_master_newest_version', $google_ads_master_version );
}
}
if (!empty($r)){
$google_ads_plugin_slug = $google_ads_master_slug.'/'.$google_ads_master_slug.'.php';
@$r = $current->response[ $google_ads_plugin_slug ];
if( is_multisite() ) {
update_site_option( 'google_ads_master_newest_version', $r->new_version );
}
else{
update_option( 'google_ads_master_newest_version', $r->new_version );
}
}
}
		// Advanced Updater

//END CLASS
}
if ( is_admin() ){
	add_action('admin_init', array('google_ads_master', 'google_ads_master_register'));
	add_action('init', array('google_ads_master', 'google_ads_master_updater_version_check'));
}
add_filter('the_content', array('google_ads_master', 'content_with_quote'));
add_filter( 'plugin_action_links', array('google_ads_master', 'google_ads_master_links'), 10, 2 );
endif;