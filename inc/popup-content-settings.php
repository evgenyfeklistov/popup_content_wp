<?php
/**
 * Страница настроек для плагина
 *
 * @since    1.0.0
 */

add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
	add_options_page( 
		'Popup Content',
		'Настройка Popup Content',
		'manage_options',
		'popup_content_settings',
		'popup_content_options_page_output' );
}

function popup_content_options_page_output(){
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>

		<form action="options.php" method="POST">
			<?php
				settings_fields( 'popup_content_option_group' );     // скрытые защитные поля
				do_settings_sections( 'popup_content_settings_page' ); // секции с настройками (опциями). У нас она всего одна 'popup_content_option_section_1'
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'plugin_settings');
function plugin_settings(){
	// параметры: $popup_content_option_group, $popup_content_option, $sanitize_callback
	register_setting( 'popup_content_option_group', 'popup_content_option', 'sanitize_callback' );

	// параметры: $id, $title, $callback, $page
	add_settings_section( 'popup_content_option_section_1', 'Основные настройки', '', 'popup_content_settings_page' ); 

	// параметры: $id, $title, $callback, $page, $section, $args
	add_settings_field('popup_content_wrap_class', 'Класс для обертки (wrapper)', 'popup_content_wrap_class', 'popup_content_settings_page', 'popup_content_option_section_1' );
	add_settings_field('popup_content_main_class', 'Класс основной', 'popup_content_main_class', 'popup_content_settings_page', 'popup_content_option_section_1' );
	add_settings_field('popup_content_link_class', 'Класс для ссылок', 'popup_content_link_class', 'popup_content_settings_page', 'popup_content_option_section_1' );
	add_settings_field('popup_content_close_link_class', 'Класс для ссылок закрытия', 'popup_content_close_link_class', 'popup_content_settings_page', 'popup_content_option_section_1' );
}

// Popup content wrapper
function popup_content_wrap_class(){
	$val = get_option('popup_content_option');
	
	if ( !empty($val) ) {
		$val = $val['popup_content_wrapper_class'];
	} else {
		$val = null;
	}
	
	?>
	<input type="text" name="popup_content_option[popup_content_wrapper_class]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

// Popup content main
function popup_content_main_class(){
	$val = get_option('popup_content_option');
	
	if ( !empty($val) ) {
		$val = $val['popup_content_main_class'];
	} else {
		$val = null;
	}
	
	?>
	<input type="text" name="popup_content_option[popup_content_main_class]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

// Popup content open link
function popup_content_link_class(){
	$val = get_option('popup_content_option');
	
	if ( !empty($val) ) {
		$val = $val['popup_content_link_class'];
	} else {
		$val = null;
	}
	
	?>
	<input type="text" name="popup_content_option[popup_content_link_class]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

// Popup content close link
function popup_content_close_link_class(){
	$val = get_option('popup_content_option');
	
	if ( !empty($val) ) {
		$val = $val['popup_content_close_link_class'];
	} else {
		$val = null;
	}
	
	?>
	<input type="text" name="popup_content_option[popup_content_close_link_class]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

## Очистка данных
function sanitize_callback( $options ){ 

	foreach( $options as $name => & $val ){
		if( $name == 'popup_content_wrapper_class' ){
			$val = strip_tags( $val );
		}

		if( $name == 'popup_content_main_class' ){
			$val = strip_tags( $val );
		}

		if( $name == 'popup_content_link_class' ){
			$val = strip_tags( $val );
		}
	}
	
	return $options;
}