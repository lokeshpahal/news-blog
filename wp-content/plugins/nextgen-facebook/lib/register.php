<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'NgfbRegister' ) ) {

	class NgfbRegister {

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			register_activation_hook( NGFB_FILEPATH, array( &$this, 'network_activate' ) );
			register_deactivation_hook( NGFB_FILEPATH, array( &$this, 'network_deactivate' ) );
			register_uninstall_hook( NGFB_FILEPATH, array( __CLASS__, 'network_uninstall' ) );

			add_action( 'wpmu_new_blog', array( &$this, 'wpmu_new_blog' ), 10, 6 );
			add_action( 'wpmu_activate_blog', array( &$this, 'wpmu_activate_blog' ), 10, 5 );
		}

		// fires immediately after a new site is created
		public function wpmu_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
			switch_to_blog( $blog_id );
			$this->activate_plugin();
			restore_current_blog();
		}

		// fires immediately after a site is activated
		// (not called when users and sites are created by a Super Admin)
		public function wpmu_activate_blog( $blog_id, $user_id, $password, $signup_title, $meta ) {
			switch_to_blog( $blog_id );
			$this->activate_plugin();
			restore_current_blog();
		}

		public function network_activate( $sitewide ) {
			self::do_multisite( $sitewide, array( &$this, 'activate_plugin' ) );
		}

		public function network_deactivate( $sitewide ) {
			self::do_multisite( $sitewide, array( &$this, 'deactivate_plugin' ) );
		}

		public static function network_uninstall() {
			$sitewide = true;
			$cf = NgfbConfig::get_config();

			// uninstall from the individual blogs first
			self::do_multisite( $sitewide, array( __CLASS__, 'uninstall_plugin' ) );

			if ( ! defined( 'NGFB_SITE_OPTIONS_NAME' ) )
				define( 'NGFB_SITE_OPTIONS_NAME', $cf['lca'].'_site_options' );

			$opts = get_site_option( NGFB_SITE_OPTIONS_NAME );

			if ( empty( $opts['plugin_preserve'] ) )
				delete_site_option( NGFB_SITE_OPTIONS_NAME );
		}

		private static function do_multisite( $sitewide, $method, $args = array() ) {
			if ( is_multisite() && $sitewide ) {
				global $wpdb;
				$dbquery = 'SELECT blog_id FROM '.$wpdb->blogs;
				$ids = $wpdb->get_col( $dbquery );
				foreach ( $ids as $id ) {
					switch_to_blog( $id );
					call_user_func_array( $method, array( $args ) );
				}
				restore_current_blog();
			} else call_user_func_array( $method, array( $args ) );
		}

		private function activate_plugin() {
			global $wp_version;
			$lca = $this->p->cf['lca'];
			$short = $this->p->cf['plugin'][$lca]['short'];
			if ( version_compare( $wp_version, $this->p->cf['wp']['min_version'], '<' ) ) {
				require_once( ABSPATH.'wp-admin/includes/plugin.php' );
				deactivate_plugins( NGFB_PLUGINBASE );
				error_log( NGFB_PLUGINBASE.' requires WordPress '.$this->p->cf['wp']['min_version'].' or higher ('.$wp_version.' reported).' );
				wp_die( '<p>'. sprintf( __( 'Sorry, the %1$s plugin cannot be activated &mdash; it requires WordPress version %2$s or newer.', NGFB_TEXTDOM ), 
					$short, $this->p->cf['wp']['min_version'] ).'</p>' );
			}
			set_transient( $lca.'_activation_redirect', true, 60 * 60 );
			$this->p->set_config();
			$this->p->set_objects( true );
		}

		private function deactivate_plugin() {
			$slug = $this->p->cf['plugin'][$this->p->cf['lca']]['slug'];
			wp_clear_scheduled_hook( 'plugin_updates-'.$slug );
		}

		private static function uninstall_plugin() {
			global $wpdb;
			$cf = NgfbConfig::get_config();

			if ( ! defined( 'NGFB_OPTIONS_NAME' ) )
				define( 'NGFB_OPTIONS_NAME', $cf['lca'].'_options' );

			if ( ! defined( 'NGFB_META_NAME' ) )
				define( 'NGFB_META_NAME', '_'.$cf['lca'].'_meta' );

			if ( ! defined( 'NGFB_PREF_NAME' ) )
				define( 'NGFB_PREF_NAME', '_'.$cf['lca'].'_pref' );

			$slug = $cf['plugin'][$cf['lca']]['slug'];
			$opts = get_option( NGFB_OPTIONS_NAME );

			if ( empty( $opts['plugin_preserve'] ) ) {
				delete_option( NGFB_OPTIONS_NAME );
				delete_post_meta_by_key( NGFB_META_NAME );
				foreach ( array( NGFB_META_NAME, NGFB_PREF_NAME ) as $meta_key )
					foreach ( get_users( array( 'meta_key' => $meta_key ) ) as $user )
						delete_user_option( $user->ID, $meta_key );
				NgfbUser::delete_metabox_prefs();
			}

			// delete update options
			delete_option( 'external_updates-'.$slug );
			delete_option( $cf['lca'].'_umsg' );
			delete_option( $cf['lca'].'_utime' );

			// delete stored notices
			foreach ( array( 'nag', 'err', 'inf' ) as $type ) {
				$msg_opt = $cf['lca'].'_notices_'.$type;
				delete_option( $msg_opt );
				foreach ( get_users( array( 'meta_key' => $msg_opt ) ) as $user )
					delete_user_option( $user->ID, $msg_opt );
			}

			// delete transients
			$dbquery = 'SELECT option_name FROM '.$wpdb->options.' WHERE option_name LIKE \'_transient_timeout_'.$cf['lca'].'_%\';';
			$expired = $wpdb->get_col( $dbquery ); 
			foreach( $expired as $transient ) { 
				$key = str_replace('_transient_timeout_', '', $transient);
				if ( ! empty( $key ) )
					delete_transient( $key );
			}
		}
	}
}

?>
