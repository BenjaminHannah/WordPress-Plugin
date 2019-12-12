<?php
/**
* @package Paywall Plugin
*/

/*
Plugin Name: Paywall Plugin by Page Pioneers
Plugin URI: http://pagepioneers.com/paywall-plugin
Description: This is my first attempt at writing a custom plugin.
Version: 1.0.0
Author: Benjamin Hannah
Author URI: http://pagepioneers.com/plugin-author
License: GPLv2 or later
Text Domain: paywall-by-pagepioneers
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

#Simple security check
defined( 'ABSPATH' ) or die;

if ( !class_exists('paywallByPagePioneers')){
	class paywallByPagePioneers{

		public $plugin;

		function __construct(){
			$this->plugin = plugin_basename(__FILE__);
		}

		function register(){
			//add_action('wp_enqueue_scripts', array($this, 'enqueue')); //this would change the front end! :D
			//add_action('admin_enqueue_scripts', array($this, 'enqueue'));
		
			//add_aciton( 'admin_menu', array($this, 'add_admin_pages'));

			//new
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
			add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
		}

		function settings_link( $links ) {
			$settings_link = '<a href="admin.php?page=paywall_plugin">Paywall Plugin</a>';
			array_push( $links, $settings_link );
			return $links;
		}

		function add_admin_pages() {
			add_menu_page('Paywall Plugin', 'Paywall', 'manage_options', 'paywall_plugin', array( $this, 'admin_index'), 'dashicons-unlock', 110);
		}

		function admin_index() {
			// require template
			require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php'; //*
		}

		function create_post_type(){
			add_action( 'init', array( $this, 'custom_post_type' ) );
		}

		function custom_post_type() {
			register_post_type( 'book', ['public' => true, 'label' => 'Books'] );
		}


		function enqueue(){
			// enqueue all of the scripts
			wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
			wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
		}

		function activate(){
			//generated a CPT
			////$this->custom_post_type();
			// flush rewrite rules
			////flush_rewrite_rules();

			require_once plugin_dir_path( __FILE__ ) . 'inc/paywall-plugin-activate.php';
			PaywallPluginActivate::activate();

		}

	}

	$paywallPlugin = new paywallByPagePioneers();
	$paywallPlugin->register();

	// activation
	register_activation_hook(__FILE__, array($paywallByPagePioneers, 'activate') );


	// deactivation
	require_once plugin_dir_path( __FILE__ ) . 'inc/paywall-plugin-deactivate.php';
	register_deactivation_hook(__FILE__, array($paywallByPagePioneers, 'deactivate') );

}