<?php
/*
Plugin name: Dop Dop Mail
Plugin uri: http://www.teste.com.br
Description: Com este plugin voce gerência e personaliza seus formulários e envios de email de forma livre e dinâmica.
Version: 1.0
Author: Ronaldo
Author uri: http://www.ronaldogs.blogspot.com.br
Licence: GPL2 


{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/
  
require_once (dirname(__FILE__).'/class-submenu.php');
require_once (dirname(__FILE__).'/list-admin-dopdop-mail.php');

  Class main_plugin_dopdop_mail{

	private static $instance;

	public static function getInstance(){

		if(self::$instance == NULL){
			self::$instance = new self();
		}
	}

	private function __construct(){
		add_action( 'plugins_loaded', array($this, 'dopdop_mail_create_table') );
		add_action( 'plugins_loaded', array($this, 'config_dopdop_mail_create_table') );
		add_action( 'plugins_loaded', array($this, 'data_dopdop_mail_create_table') );		
		add_action( 'plugins_loaded', array($this, 'dopdop_mail_initial_admin') );
		add_shortcode( 'ddm', array($this, 'dopdop_mail_wp_shortcode_function_ddm' ) );
		add_filter( 'plugin_action_links_'.plugin_basename(__FILE__),  array($this, 'add_plugin_page_settings_link') );
	}

	function dopdop_mail_wp_shortcode_function_ddm( $atts ) {
		add_action('wp_footer', array($this, 'scripts_dopdop_mail'));
	    $atts = shortcode_atts(
	        array(
	            'id' => 0,
	            'title' => 'default title',
	        ), $atts, 'dopdop_mail' );
	 
	    if($atts['id'] == 0){
	    	return $atts;	
	    }else{
			global $wpdb;

          	$table_name = $wpdb->prefix . "dopdop_mail";

         	$sql = $wpdb->prepare("SELECT id, form_name, form_value, form_css FROM $table_name WHERE id = %d", array(esc_attr($atts['id'])));
          	$results = $wpdb->get_results($sql);

          	if( !empty($results[0]) ){
            	foreach ($results as $result) {
            		echo "<div id='formDopDopMail'>";
            		echo "<input hidden type='hidden' name='form_id' value='".$result->id."'>";
	          		echo unserialize($result->form_value);
	          		echo "<style>";
	          		echo $result->form_css;
	          		echo "</style>";
	          		echo "</div>";
	          	}
	        }
	    }  
	}


	function scripts_dopdop_mail(){
	    echo "<script src=".plugins_url('dopdop-mail/scripts.js')."></script>";
	}

	function dopdop_mail_create_table(){
    
	    global $wpdb;
	    
	    $table_name = $wpdb->base_prefix.'dopdop_mail';
	    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( ! $wpdb->get_var( $query ) == $table_name ) {

		    $cfdb       = apply_filters( 'dopdop_mail_database', $wpdb );
		    $table_name = $cfdb->prefix.'dopdop_mail';

		    if( $cfdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

		        $charset_collate = $cfdb->get_charset_collate();

		        $sql = "CREATE TABLE $table_name (
		            id bigint(20) NOT NULL AUTO_INCREMENT,
		            form_author text NOT NULL,
		            form_name text NOT NULL,
		            form_value longtext NOT NULL,
		            form_css longtext NOT NULL,
		            date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		            date_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		            date_deleted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		            PRIMARY KEY  (id)
		        ) $charset_collate;";

		        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		        dbDelta( $sql );
		    }
		} 
	}

	function config_dopdop_mail_create_table(){
    
	    global $wpdb;
	    
	    $table_name = $wpdb->base_prefix.'config_dopdop_mail';
	    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( ! $wpdb->get_var( $query ) == $table_name ) {
	    	
	    	$cfdb       = apply_filters( 'config_dopdop_mail_database', $wpdb );
	        $charset_collate = $cfdb->get_charset_collate();

	        $sql = "CREATE TABLE $table_name (
	            id bigint(20) NOT NULL AUTO_INCREMENT,
	            form_id bigint(20) NOT NULL,
	            form_author text NOT NULL,
	            config_tipo text NOT NULL,
	            config_data JSON NOT NULL,
	            date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            date_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            PRIMARY KEY  (id)
	        ) $charset_collate;";

	        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        dbDelta( $sql );    
		} 
	}

	function data_dopdop_mail_create_table(){
    
	    global $wpdb;
	    
	    $table_name = $wpdb->base_prefix.'data_dopdop_mail';
	    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( ! $wpdb->get_var( $query ) == $table_name ) {
	    	
	    	$cfdb       = apply_filters( 'data_dopdop_mail_database', $wpdb );
	        $charset_collate = $cfdb->get_charset_collate();

	        $sql = "CREATE TABLE $table_name (
	            id bigint(20) NOT NULL AUTO_INCREMENT,
	            form_id bigint(20) NOT NULL,
	            form_data JSON NOT NULL,
	            form_data_headers JSON NOT NULL,
	            date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            date_deleted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	            PRIMARY KEY (id)
	        ) $charset_collate;";

	        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        dbDelta( $sql );    
		} 
	}

	function add_plugin_page_settings_link( $links ) {
		$links[] = '<a href="' .
			admin_url( 'options-general.php?page=dopdop-mail' ) .
			'">' . __('Settings') . '</a>';
		return $links;
	}

	function dopdop_mail_initial_admin() {
	    $plugin = new Submenu( new Admin_List_Dopdop_Mail() );
	    $plugin->init();
	}
}

main_plugin_dopdop_mail::getInstance();