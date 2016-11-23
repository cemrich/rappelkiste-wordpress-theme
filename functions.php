<?php
function my_theme_enqueue_styles() {

		$parent_style = 'parent-style';

		wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
		wp_enqueue_style('child-style',
				get_stylesheet_directory_uri() . '/style.css',
				array( $parent_style ),
				wp_get_theme()->get('Version')
		);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

class Rappelkiste_Customize {
	
	public static function register ( $wp_customize ) {
		// second color
		$wp_customize->add_setting('accent_color_2', 
			array(
				'default' => '#ff6600',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize, 'rappelkiste_accent_color_2',
				array(
					'label' => __('Accent Color 2', 'rappelkiste'),
					'section' => 'colors',
					'settings' => 'accent_color_2',
					'priority' => 11,
				) 
			)
		);
		
		// hide website info
		$wp_customize->add_setting('rappelkiste_hide_website_info', array(
			'default' => '1'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'rappelkiste_hide_website_info',
				array(
					'label'     => __('Hide website information', 'rappelkiste'),
					'section'   => 'title_tagline',
					'settings'  => 'rappelkiste_hide_website_info',
					'type'      => 'checkbox',
				)
			)
		);
		
		// for live preview
		$wp_customize->get_setting('accent_color_2')->transport = 'postMessage';
	}
	
	public static function header_output() {
		?>
		<!-- rappelkiste Customizer css -->
		
		<style type="text/css">
			<?php self::generate_css('.section.bg-dark', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.blog-search', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.navigation', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.toggle-container', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.mobile-menu a', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.search-toggle .glass', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.blog-menu ul li', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.blog-menu li:hover a', 'background-color', 'accent_color_2'); ?>
			<?php self::generate_css('.blog-info', 'background-color', 'accent_color_2'); ?>
			
			<?php self::generate_css('::selection', 'background', 'accent_color_2'); ?>
				
			<?php self::generate_css('.post-meta a', 'color', 'accent_color_2'); ?>
			<?php self::generate_css('.post-meta span', 'color', 'accent_color_2'); ?>
			<?php self::generate_css('.post', 'border-color', 'accent_color_2'); ?>
			<?php self::generate_css('.page', 'border-color', 'accent_color_2'); ?>
			
			<?php self::generate_css('.post-nav', 'border-color', 'accent_color'); ?>
			<?php self::generate_css('.widget', 'border-color', 'accent_color'); ?>
		</style>
		
		<!-- /rappelkiste Customizer css -->
		<?php
	}
	
	 public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
		$return = '';
		$mod = get_theme_mod($mod_name);
		if (!empty($mod)) {
			$return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix.$mod.$postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}
		return $return;
	}
	
	/**
	 * Used by hook: 'customize_preview_init'
	 * 
	 * @see add_action('customize_preview_init',$func)
	 */
	public static function live_preview() {
		wp_enqueue_script( 
			'rappelkiste-themecustomizer',
			get_stylesheet_directory_uri() . '/js/theme-customizer.js',
			array('jquery','customize-preview'),
			'',
			true //Put script in footer?
		);
	}
}

add_action('customize_register' , array('Rappelkiste_Customize' , 'register'));
add_action('wp_head' , array('Rappelkiste_Customize', 'header_output'));
add_action('customize_preview_init', array('Rappelkiste_Customize', 'live_preview'));

?>
