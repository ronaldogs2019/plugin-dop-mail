<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}


function add_theme_scripts() {

    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
    wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.4.1.slim.min.js');
    wp_enqueue_script('jquery');
    wp_register_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
    wp_enqueue_script('popper');
    wp_register_script( 'scripts', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js');
    wp_enqueue_script('scripts');
    wp_register_style('styles_css', plugins_url('dopdop-mail/styles.css'));
    wp_enqueue_style('styles_css');
}
add_action( 'admin_init', 'add_theme_scripts' );