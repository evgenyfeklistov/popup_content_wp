<?php

/**
 * @link              http://el-duderino.ru/
 * @since             1.0.0
 * @package           Popup_content
 *
 * @wordpress-plugin
 * Plugin Name:       Popup Content
 * Plugin URI:        http://el-duderino.ru/
 * Description:       Попапы через ajax
 * Version:           1.0.0
 * Author:            Big Feklistowski
 * Author URI:        http://el-duderino.ru/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       popup-content
 * Domain Path:       /languages
 */


/**
* Settings page
*/
require plugin_dir_path( __FILE__ ) . 'inc/popup-content-settings.php';

/**
* Assets
*/
add_action( 'wp_enqueue_scripts', 'popup_content_scripts', 99 );
function popup_content_scripts(){
    
    $popupContentOptions = get_option('popup_content_option');

	wp_localize_script( 'fatzilla_js', 'popupContentParams', 
		array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'linkClass' => $popupContentOptions['popup_content_link_class'],
            'closeLinkClass' => $popupContentOptions['popup_content_close_link_class'],
            'wrapClass' => $popupContentOptions['popup_content_wrapper_class'],
            'mainClass' => $popupContentOptions['popup_content_main_class']
		)
    );  
    
    // Main scripts and styles
    wp_enqueue_script('popup_content_js', plugin_dir_url(__FILE__).'assets/js/main.js', array('jquery') );
    wp_enqueue_style('popup_content_css', plugin_dir_url(__FILE__).'assets/css/main.css');

}


/**
* Ajax actions
*/
add_action('wp_ajax_popup_content', 'popup_content_callback');
add_action('wp_ajax_nopriv_popup_content', 'popup_content_callback');

function popup_content_callback() {

	$postId = intval( $_POST['postId'] );
	$post = get_post( $postId );
	$postTitle = $post->post_title;
	$postContent = apply_filters( 'the_content', $post->post_content );
	
	echo '<div id="popup-post-'.$postId.'" class="popup">
		<div class="popup__inner">
		<div class="popup__title">'.$postTitle.'</div>
	<div class="popup__content">'.$postContent.'</div>';

	wp_die();
}