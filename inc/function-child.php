<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

	// Load justg_child_enqueue_parent_style after theme setup
	add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

	if (class_exists('Kirki')) :

		Kirki::add_panel('panel_velocity', [
			'priority'    => 10,
			'title'       => esc_html__('Velocity Theme', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		Kirki::add_panel('panel_perusahaan', [
			'priority'    => 10,
			'title'       => esc_html__('Perusahaan Setting', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		// section title_tagline
		Kirki::add_section('title_tagline', [
			'panel'    => 'panel_velocity',
			'title'    => __('Site Identity', 'justg'),
			'priority' => 10,
		]);

		///Section Color
		Kirki::add_section('section_colorvelocity', [
			'panel'    => 'panel_velocity',
			'title'    => __('Color & Background', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Theme Color', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => '#00715b',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-primary',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				],
				[
					'element'	=> '.text-color-theme',
					'property'	=> 'color',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_bgtheme',
			'label'       => __('Header & Footer Background', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => '#00715b',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => '.bg-theme',
					'property'  => 'background-color',
					'suffix'	=> ' !important',
				],
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_themewebsite',
			'label'       => __('Website Background', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => [
				'background-color'      => 'rgba(255,255,255)',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root[data-bs-theme=light] body',
				],
				[
					'element'   => 'body',
				],
			],
		]);

		// section header
		Kirki::add_section('section_kontak', [
			'panel'    => 'panel_perusahaan',
			'title'    => __('Kontak', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'notel',
			'label'       => __('No Telepon', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_kontak',
			'default'     => '',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'email',
			'label'       => __('Email', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_kontak',
			'default'     => '',
		]);

		// section header
		Kirki::add_section('section_homebanner', [
			'panel'    => 'panel_perusahaan',
			'title'    => __('Home Banner', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'image',
			'settings'    => 'home_banner',
			'label'       => esc_html__( 'Home Banner Utama', 'justg' ),
			'description' => esc_html__( '', 'justg' ),
			'section'     => 'section_homebanner',
			'default'     => '',
			'choices'     => ['save_as' => 'id',],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'subtitle_banner',
			'label'       => __('Sub Title Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Selamat Datang di',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'title_banner',
			'label'       => __('Title Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Perusahaan 2<br/> Velocity Developer',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'editor',
			'settings'    => 'content_banner',
			'label'       => __('Content Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => '',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'button1_banner',
			'label'       => __('Button Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Hubungi Kami',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'url',
			'settings'    => 'link1_banner',
			'label'       => __('Link Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => '#',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'button2_banner',
			'label'       => __('Button Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Layanan',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'url',
			'settings'    => 'link2_banner',
			'label'       => __('Link Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => '#',
		]);

		// section sambutan
		Kirki::add_section('section_sambutan', [
			'panel'    => 'panel_perusahaan',
			'title'    => __('Sambutan', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'image',
			'settings'    => 'sambutan_image',
			'label'       => esc_html__( 'Sambutan Image', 'justg' ),
			'description' => esc_html__( '', 'justg' ),
			'section'     => 'section_sambutan',
			'default'     => '',
			'choices'     => ['save_as' => 'id',],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'editor',
			'settings'    => 'sambutan',
			'label'       => __('Sambutan', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_sambutan',
			'default'     => '',
		]);

		// section layanan
		Kirki::add_section('section_layanan', [
			'panel'    => 'panel_perusahaan',
			'title'    => __('Layanan', 'justg'),
			'priority' => 10,
		]);
		new \Kirki\Field\Repeater([
			'settings'     => 'layanan_repeater',
			'label'        => esc_html__( 'Layanan Control', 'justg' ),
			'section'      => 'section_layanan',
			'priority'     => 10,
			'row_label'    => [
				'type'  => 'field',
				'value' => esc_html__( 'Layanan Anda', 'justg' ),
				// 'field' => 'link_text',
			],
			'button_label'	=> esc_html__( 'Tambah Layanan', 'justg' ),
			'default'		=> ['', 'justg'],
			'choices'		=> ['limit' => 3],
			'fields'		=> [
				'layanan_image'	=> [
					'type'	=> 'image',
					'label'	=> esc_html__( 'Layanan Image', 'justg' ),
					'description'	=> esc_html__( 'Gambar Layanan', 'justg' ),
					'default'	=> '',
					'choices'	=> ['save_as' => 'id',],
				],
				'layanan_title'	=> [
					'type'	=> 'text',
					'label'	=> esc_html__( 'Judul Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
				'layanan_content'	=> [
					'type'	=> 'textarea',
					'label'	=> esc_html__( 'Deskripsi Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
				'layanan_linktext'	=> [
					'type'	=> 'text',
					'label'	=> esc_html__( 'Teks Link', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
				'layanan_link'	=> [
					'type'	=> 'url',
					'label'	=> esc_html__( 'Link Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
			],
		]);

		// section home_logo
		Kirki::add_section('section_homelogo', [
			'panel'    => 'panel_perusahaan',
			'title'    => __('Logo Home', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'title_homelogo',
			'label'       => esc_html__( 'Judul', 'justg' ),
			'description' => esc_html__( '', 'justg' ),
			'section'     => 'section_homelogo',
			'default'     => 'Klien Kami',
		]);
		new \Kirki\Field\Repeater([
			'settings'     => 'logo_repeater',
			'label'        => esc_html__( 'Logo Home Control', 'justg' ),
			'section'      => 'section_homelogo',
			'priority'     => 10,
			'row_label'    => [
				'type'  => 'field',
				'value' => esc_html__( 'Logo Anda', 'justg' ),
				// 'field' => 'link_text',
			],
			'button_label'	=> esc_html__( 'Tambah Gambar', 'justg' ),
			'default'		=> ['', 'justg'],
			'choices'		=> ['limit' => 10],
			'fields'		=> [
				'logo_image'	=> [
					'type'	=> 'image',
					'label'	=> esc_html__( 'Gambar Logo', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
					'choices'	=> ['save_as' => 'id',],
				],
			],
		]);



		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_header');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_panel('panel_antispam');
		Kirki::remove_section('header_image');

	endif;

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
	remove_theme_support('widgets-block-editor');
}


///remove breadcrumbs
add_action('wp_head', function () {
	if (!is_single()) {
		remove_action('justg_before_title', 'justg_breadcrumb');
	}
});

if (!function_exists('justg_header_open')) {
	function justg_header_open()
	{
		echo '<header id="wrapper-header">';
		echo '<div id="wrapper-navbar" class="p-0 border-bottom" itemscope itemtype="http://schema.org/WebSite">';
	}
}
if (!function_exists('justg_header_close')) {
	function justg_header_close()
	{
		echo '</div>';
		echo '</header>';
	}
}

// remove some widgets
add_action('widgets_init', 'remove_some_widgets', 11);
function remove_some_widgets()
{
    unregister_sidebar('footer-widget-4');
}

///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}

add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
	// echo '<div class="px-2">';
}

add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
	// echo '</div>';
}


// excerpt more
add_filter( 'excerpt_more', 'velocity_custom_excerpt_more' );
if ( ! function_exists( 'velocity_custom_excerpt_more' ) ) {
	function velocity_custom_excerpt_more( $more ) {
		return '...';
	}
}

// excerpt length
add_filter('excerpt_length','velocity_excerpt_length');
function velocity_excerpt_length($length){
	return 20;
}

if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('main-sidebar')) {
			return;
		}
		echo '<div class="left-sidebar widget-area pe-md-2 ps-md-0 col-sm-12 col-md-3 order-3 order-md-1" id="left-sidebar" role="complementary">';
		do_action('justg_before_main_sidebar');
		dynamic_sidebar('main-sidebar');
		do_action('justg_after_main_sidebar');
		echo '</div>';
	}
}

// excerpt
function vdberita_limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]).'...';
    }
    return $text;
}
