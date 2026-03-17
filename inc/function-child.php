<?php

/**
 * Child theme functions.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);
add_action('customize_register', 'velocitychild_customize_register', 30);
add_action('customize_controls_enqueue_scripts', 'velocitychild_customize_control_assets');
add_filter('justg_theme_default_settings', 'velocitychild_default_settings', 20);

if (class_exists('WP_Customize_Control') && !class_exists('VelocityChild_Customize_Editor_Control')) {
	/**
	 * TinyMCE editor control for WordPress Customizer.
	 */
	class VelocityChild_Customize_Editor_Control extends WP_Customize_Control {
		public $type = 'velocitychild_editor';

		public function render_content() {
			$editor_id = sanitize_html_class('velocitychild_editor_' . $this->id);
			?>
			<label>
				<?php if (!empty($this->label)) : ?>
					<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<?php endif; ?>
				<?php if (!empty($this->description)) : ?>
					<span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
				<?php endif; ?>
				<textarea id="<?php echo esc_attr($editor_id); ?>" class="widefat velocitychild-editor-field" rows="8" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
			</label>
			<?php
		}
	}
}

if (!function_exists('velocitychild_default_settings')) {
	function velocitychild_default_settings($defaults) {
		$child_defaults = array(
			'notel'            => '',
			'email'            => '',
			'home_banner'      => 0,
			'subtitle_banner'  => 'Selamat Datang di',
			'title_banner'     => 'Perusahaan 2<br>Velocity Developer',
			'content_banner'   => '',
			'button1_banner'   => 'Hubungi Kami',
			'link1_banner'     => '#',
			'button2_banner'   => 'Layanan',
			'link2_banner'     => '#',
			'sambutan_image'   => 0,
			'sambutan'         => '',
			'layanan_repeater' => array(),
			'title_homelogo'   => 'Klien Kami',
			'logo_repeater'    => array(),
		);

		return array_merge($defaults, $child_defaults);
	}
}

if (!function_exists('velocitychild_customize_control_assets')) {
	function velocitychild_customize_control_assets() {
		$theme   = wp_get_theme();
		$version = $theme ? $theme->get('Version') : '1.0.0';

		wp_enqueue_media();

		if (function_exists('wp_enqueue_editor')) {
			wp_enqueue_editor();
		}

		$editor_js_path    = get_stylesheet_directory() . '/js/customizer-editor.js';
		$repeater_css_path = get_stylesheet_directory() . '/css/customizer-repeater.css';
		$repeater_js_path  = get_stylesheet_directory() . '/js/customizer-repeater.js';

		$editor_js_ver    = file_exists($editor_js_path) ? filemtime($editor_js_path) : $version;
		$repeater_css_ver = file_exists($repeater_css_path) ? filemtime($repeater_css_path) : $version;
		$repeater_js_ver  = file_exists($repeater_js_path) ? filemtime($repeater_js_path) : $version;

		wp_enqueue_script('velocitychild-customizer-editor', get_stylesheet_directory_uri() . '/js/customizer-editor.js', array('jquery', 'customize-controls', 'editor'), $editor_js_ver, true);
		wp_enqueue_style('velocitychild-customizer-repeater', get_stylesheet_directory_uri() . '/css/customizer-repeater.css', array(), $repeater_css_ver);
		wp_enqueue_script('velocitychild-customizer-repeater', get_stylesheet_directory_uri() . '/js/customizer-repeater.js', array('jquery', 'customize-controls', 'media-editor', 'media-views', 'editor'), $repeater_js_ver, true);
	}
}

if (!function_exists('velocitychild_decode_repeater_value')) {
	function velocitychild_decode_repeater_value($value) {
		if (is_string($value)) {
			$decoded = json_decode($value, true);
			if (json_last_error() === JSON_ERROR_NONE) {
				$value = $decoded;
			}
		}

		if (!is_array($value)) {
			return array();
		}

		return $value;
	}
}

if (!function_exists('velocitychild_resolve_image_value_to_url')) {
	function velocitychild_resolve_image_value_to_url($value, $size = 'full') {
		if (is_numeric($value)) {
			$image_id = absint($value);
			if ($image_id > 0) {
				$image_url = wp_get_attachment_image_url($image_id, $size);
				if ($image_url) {
					return $image_url;
				}
			}
		}

		$image_url = esc_url_raw((string) $value);
		if (!empty($image_url)) {
			return $image_url;
		}

		return '';
	}
}

if (!function_exists('velocitychild_sanitize_banner_title')) {
	function velocitychild_sanitize_banner_title($value) {
		return wp_kses((string) $value, array('br' => array()));
	}
}

if (!function_exists('velocitychild_sanitize_editor_content')) {
	function velocitychild_sanitize_editor_content($value) {
		return wp_kses_post((string) $value);
	}
}

if (!function_exists('velocitychild_get_layanan_repeater_fields')) {
	function velocitychild_get_layanan_repeater_fields() {
		return array(
			'layanan_image' => array(
				'type'        => 'image',
				'label'       => __('Layanan Image', 'justg'),
				'description' => __('Gambar layanan.', 'justg'),
				'default'     => '',
			),
			'layanan_title' => array(
				'type'    => 'text',
				'label'   => __('Judul Layanan', 'justg'),
				'default' => '',
			),
			'layanan_content' => array(
				'type'        => 'editor',
				'label'       => __('Deskripsi Layanan', 'justg'),
				'description' => __('Bisa pakai HTML sederhana.', 'justg'),
				'default'     => '',
			),
			'layanan_linktext' => array(
				'type'    => 'text',
				'label'   => __('Teks Link', 'justg'),
				'default' => '',
			),
			'layanan_link' => array(
				'type'    => 'url',
				'label'   => __('Link Layanan', 'justg'),
				'default' => '',
			),
		);
	}
}

if (!function_exists('velocitychild_get_legacy_layanan_items')) {
	function velocitychild_get_legacy_layanan_items() {
		$value = velocitytheme_option('layanan_repeater', array());
		return velocitychild_sanitize_layanan_repeater($value);
	}
}

if (!function_exists('velocitychild_sanitize_layanan_repeater')) {
	function velocitychild_sanitize_layanan_repeater($value) {
		$items = velocitychild_decode_repeater_value($value);
		$clean = array();

		foreach ($items as $item) {
			if (!is_array($item)) {
				continue;
			}

			$image_raw = isset($item['layanan_image']) ? $item['layanan_image'] : '';
			$image     = '';
			if (is_numeric($image_raw) && absint($image_raw) > 0) {
				$image = absint($image_raw);
			} elseif (!empty($image_raw)) {
				$image = esc_url_raw((string) $image_raw);
			}

			$title    = isset($item['layanan_title']) ? sanitize_text_field((string) $item['layanan_title']) : '';
			$content  = isset($item['layanan_content']) ? wp_kses_post((string) $item['layanan_content']) : '';
			$linktext = isset($item['layanan_linktext']) ? sanitize_text_field((string) $item['layanan_linktext']) : '';
			$link     = isset($item['layanan_link']) ? esc_url_raw((string) $item['layanan_link']) : '';

			if (empty($image) && '' === $title && '' === trim(wp_strip_all_tags($content)) && '' === $linktext && '' === $link) {
				continue;
			}

			$clean[] = array('layanan_image' => $image, 'layanan_title' => $title, 'layanan_content' => $content, 'layanan_linktext' => $linktext, 'layanan_link' => $link);
		}

		return $clean;
	}
}

if (!function_exists('velocitychild_get_home_layanan_items')) {
	function velocitychild_get_home_layanan_items() {
		$items_raw = get_theme_mod('layanan_repeater', null);
		if (null === $items_raw) {
			$items = velocitychild_get_legacy_layanan_items();
		} else {
			$items = velocitychild_sanitize_layanan_repeater($items_raw);
		}

		return $items;
	}
}

if (!function_exists('velocitychild_get_logo_repeater_fields')) {
	function velocitychild_get_logo_repeater_fields() {
		return array(
			'logo_image' => array(
				'type'        => 'image',
				'label'       => __('Gambar Logo', 'justg'),
				'description' => __('Pilih logo klien/partner.', 'justg'),
				'default'     => '',
			),
		);
	}
}

if (!function_exists('velocitychild_get_legacy_logo_items')) {
	function velocitychild_get_legacy_logo_items() {
		$value = velocitytheme_option('logo_repeater', array());
		return velocitychild_sanitize_logo_repeater($value);
	}
}

if (!function_exists('velocitychild_sanitize_logo_repeater')) {
	function velocitychild_sanitize_logo_repeater($value) {
		$items = velocitychild_decode_repeater_value($value);
		$clean = array();

		foreach ($items as $item) {
			if (!is_array($item)) {
				continue;
			}

			$image_raw = isset($item['logo_image']) ? $item['logo_image'] : '';
			$image     = '';
			if (is_numeric($image_raw) && absint($image_raw) > 0) {
				$image = absint($image_raw);
			} elseif (!empty($image_raw)) {
				$image = esc_url_raw((string) $image_raw);
			}

			if (empty($image)) {
				continue;
			}

			$clean[] = array('logo_image' => $image);
		}

		return $clean;
	}
}

if (!function_exists('velocitychild_get_home_logo_items')) {
	function velocitychild_get_home_logo_items() {
		$items_raw = get_theme_mod('logo_repeater', null);
		if (null === $items_raw) {
			$items = velocitychild_get_legacy_logo_items();
		} else {
			$items = velocitychild_sanitize_logo_repeater($items_raw);
		}

		$output = array();
		foreach ($items as $item) {
			$image_value = isset($item['logo_image']) ? $item['logo_image'] : '';
			$image_url   = velocitychild_resolve_image_value_to_url($image_value, 'large');
			if ($image_url) {
				$output[] = array('logo_image_url' => $image_url);
			}
		}

		return $output;
	}
}

if (!class_exists('Velocitychild_Repeater_Control') && class_exists('WP_Customize_Control')) {
	class Velocitychild_Repeater_Control extends WP_Customize_Control {
		public $type = 'velocity_repeater';
		public $fields = array();
		public $item_label = '';
		public $add_button_label = '';

		public function __construct($manager, $id, $args = array(), $options = array()) {
			if (isset($args['fields'])) {
				$this->fields = (array) $args['fields'];
				unset($args['fields']);
			}
			if (isset($args['item_label'])) {
				$this->item_label = (string) $args['item_label'];
				unset($args['item_label']);
			}
			if (isset($args['add_button_label'])) {
				$this->add_button_label = (string) $args['add_button_label'];
				unset($args['add_button_label']);
			}
			parent::__construct($manager, $id, $args);
		}

		protected function render_content() {
			if (empty($this->fields)) {
				return;
			}

			$value = $this->value();
			if (is_string($value)) {
				$decoded = json_decode($value, true);
				$value   = (json_last_error() === JSON_ERROR_NONE) ? $decoded : array();
			}

			if (!is_array($value)) {
				$value = array();
			}

			$encoded_value = wp_json_encode($value);
			if (empty($encoded_value)) {
				$encoded_value = '[]';
			}
			?>
			<div class="velocity-repeater-control">
				<?php if (!empty($this->label)) : ?>
					<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<?php endif; ?>
				<?php if (!empty($this->description)) : ?>
					<p class="description"><?php echo wp_kses_post($this->description); ?></p>
				<?php endif; ?>
				<div class="velocity-repeater" data-fields="<?php echo esc_attr(wp_json_encode($this->fields)); ?>" data-default-label="<?php echo esc_attr($this->item_label ? $this->item_label : __('Item', 'justg')); ?>">
					<input type="hidden" class="velocity-repeater-store" <?php $this->link(); ?> value="<?php echo esc_attr($encoded_value); ?>">
					<div class="velocity-repeater-items">
						<?php if (!empty($value)) { foreach ($value as $item) { echo $this->get_single_item_markup($item); } } ?>
					</div>
					<button type="button" class="button button-primary velocity-repeater-add"><?php echo esc_html($this->add_button_label ? $this->add_button_label : __('Tambah Item', 'justg')); ?></button>
					<script type="text/html" class="velocity-repeater-template"><?php echo $this->get_single_item_markup(array()); ?></script>
				</div>
			</div>
			<?php
		}

		private function get_single_item_markup($item_values = array()) {
			ob_start();
			$summary = $this->item_label ? $this->item_label : __('Item', 'justg');
			?>
			<div class="velocity-repeater-item">
				<button type="button" class="velocity-repeater-toggle" aria-expanded="true">
					<span class="velocity-repeater-item-label"><?php echo esc_html($summary); ?></span>
					<span class="velocity-repeater-toggle-icon" aria-hidden="true"></span>
				</button>
				<div class="velocity-repeater-item-body">
					<?php foreach ($this->fields as $field_key => $field) :
						$field_type    = isset($field['type']) ? $field['type'] : 'text';
						$field_label   = isset($field['label']) ? $field['label'] : '';
						$field_default = isset($field['default']) ? $field['default'] : '';
						$field_desc    = isset($field['description']) ? $field['description'] : '';
						$field_value   = isset($item_values[$field_key]) ? $item_values[$field_key] : $field_default;
						if ('image' === $field_type) :
							$image_value = (string) $field_value;
							$image_id    = absint($field_value);
							$image_url   = '';
							if ($image_id > 0) {
								$image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
							} elseif (filter_var($image_value, FILTER_VALIDATE_URL)) {
								$image_url = $image_value;
							}
							?>
							<div class="velocity-repeater-field">
								<span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
								<div class="velocity-repeater-image-field">
									<input type="hidden" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr($image_value); ?>">
									<div class="velocity-repeater-image-preview<?php echo $image_url ? ' has-image' : ''; ?>"><?php if ($image_url) : ?><img src="<?php echo esc_url($image_url); ?>" alt=""><?php endif; ?></div>
									<div class="velocity-repeater-image-actions"><button type="button" class="button velocity-repeater-media-select"><?php esc_html_e('Pilih Gambar', 'justg'); ?></button><button type="button" class="button-link button-link-delete velocity-repeater-media-remove"><?php esc_html_e('Hapus', 'justg'); ?></button></div>
								</div>
								<?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?>
							</div>
						<?php elseif ('editor' === $field_type) : ?>
							<label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><textarea class="velocity-repeater-editor" rows="6" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php echo esc_textarea((string) $field_value); ?></textarea><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
						<?php elseif ('textarea' === $field_type) : ?>
							<label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><textarea data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php echo esc_textarea((string) $field_value); ?></textarea><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
						<?php elseif ('select' === $field_type) : ?>
							<?php $choices = isset($field['choices']) && is_array($field['choices']) ? $field['choices'] : array(); ?>
							<label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><select data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php foreach ($choices as $choice_value => $choice_label) : ?><option value="<?php echo esc_attr((string) $choice_value); ?>" <?php selected((string) $field_value, (string) $choice_value); ?>><?php echo esc_html((string) $choice_label); ?></option><?php endforeach; ?></select><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
						<?php else : ?>
							<label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><input type="<?php echo esc_attr($field_type); ?>" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr((string) $field_value); ?>"><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="velocity-repeater-actions"><button type="button" class="button velocity-repeater-clone"><?php esc_html_e('Clone', 'justg'); ?></button><button type="button" class="button button-secondary velocity-repeater-remove"><?php esc_html_e('Hapus', 'justg'); ?></button></div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}
}

if (!function_exists('velocitychild_customize_register')) {
	function velocitychild_customize_register(WP_Customize_Manager $wp_customize) {
		$textdomain = 'justg';
		$site_identity_section = $wp_customize->get_section('title_tagline');
		if ($site_identity_section) {
			$site_identity_section->panel = '';
		}

		if (!$wp_customize->get_panel('panel_perusahaan')) {
			$wp_customize->add_panel('panel_perusahaan', array('priority' => 20, 'title' => esc_html__('Perusahaan Settings', $textdomain), 'description' => ''));
		} else {
			$panel_perusahaan = $wp_customize->get_panel('panel_perusahaan');
			if ($panel_perusahaan) {
				$panel_perusahaan->title = esc_html__('Perusahaan Settings', $textdomain);
			}
		}

		$wp_customize->add_section('section_kontak', array('panel' => 'panel_perusahaan', 'title' => __('Kontak', $textdomain), 'priority' => 10));
		$wp_customize->add_setting('notel', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('notel', array('type' => 'text', 'label' => __('No Telepon', $textdomain), 'section' => 'section_kontak'));
		$wp_customize->add_setting('email', array('default' => '', 'sanitize_callback' => 'sanitize_email'));
		$wp_customize->add_control('email', array('type' => 'email', 'label' => __('Email', $textdomain), 'section' => 'section_kontak'));

		$wp_customize->add_section('section_homebanner', array('panel' => 'panel_perusahaan', 'title' => __('Home Banner', $textdomain), 'priority' => 20));
		$wp_customize->add_setting('home_banner', array('default' => 0, 'sanitize_callback' => 'absint'));
		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'home_banner', array('label' => esc_html__('Home Banner Utama', $textdomain), 'section' => 'section_homebanner', 'mime_type' => 'image')));
		$wp_customize->add_setting('subtitle_banner', array('default' => 'Selamat Datang di', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('subtitle_banner', array('type' => 'text', 'label' => __('Sub Title Banner', $textdomain), 'section' => 'section_homebanner'));
		$wp_customize->add_setting('title_banner', array('default' => 'Perusahaan 2<br>Velocity Developer', 'sanitize_callback' => 'velocitychild_sanitize_banner_title'));
		$wp_customize->add_control('title_banner', array('type' => 'text', 'label' => __('Title Banner', $textdomain), 'description' => __('Bisa memakai tag <br> untuk pindah baris.', $textdomain), 'section' => 'section_homebanner'));
		$wp_customize->add_setting('content_banner', array('default' => '', 'sanitize_callback' => 'velocitychild_sanitize_editor_content'));
		$wp_customize->add_control(new VelocityChild_Customize_Editor_Control($wp_customize, 'content_banner', array('label' => __('Content Banner', $textdomain), 'description' => __('Bisa pakai HTML sederhana.', $textdomain), 'section' => 'section_homebanner')));
		$wp_customize->add_setting('button1_banner', array('default' => 'Hubungi Kami', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('button1_banner', array('type' => 'text', 'label' => __('Button Banner 1', $textdomain), 'section' => 'section_homebanner'));
		$wp_customize->add_setting('link1_banner', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control('link1_banner', array('type' => 'url', 'label' => __('Link Banner 1', $textdomain), 'section' => 'section_homebanner'));
		$wp_customize->add_setting('button2_banner', array('default' => 'Layanan', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('button2_banner', array('type' => 'text', 'label' => __('Button Banner 2', $textdomain), 'section' => 'section_homebanner'));
		$wp_customize->add_setting('link2_banner', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control('link2_banner', array('type' => 'url', 'label' => __('Link Banner 2', $textdomain), 'section' => 'section_homebanner'));

		$wp_customize->add_section('section_sambutan', array('panel' => 'panel_perusahaan', 'title' => __('Sambutan', $textdomain), 'priority' => 30));
		$wp_customize->add_setting('sambutan_image', array('default' => 0, 'sanitize_callback' => 'absint'));
		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'sambutan_image', array('label' => esc_html__('Sambutan Image', $textdomain), 'section' => 'section_sambutan', 'mime_type' => 'image')));
		$wp_customize->add_setting('sambutan', array('default' => '', 'sanitize_callback' => 'velocitychild_sanitize_editor_content'));
		$wp_customize->add_control(new VelocityChild_Customize_Editor_Control($wp_customize, 'sambutan', array('label' => __('Sambutan', $textdomain), 'description' => __('Bisa pakai HTML sederhana.', $textdomain), 'section' => 'section_sambutan')));

		$wp_customize->add_section('section_layanan', array('panel' => 'panel_perusahaan', 'title' => __('Layanan', $textdomain), 'priority' => 40));
		$wp_customize->add_setting('layanan_repeater', array('default' => velocitychild_get_legacy_layanan_items(), 'sanitize_callback' => 'velocitychild_sanitize_layanan_repeater'));
		$wp_customize->add_control(new Velocitychild_Repeater_Control($wp_customize, 'layanan_repeater', array('label' => esc_html__('Layanan Control', $textdomain), 'section' => 'section_layanan', 'priority' => 10, 'fields' => velocitychild_get_layanan_repeater_fields(), 'item_label' => esc_html__('Layanan', $textdomain), 'add_button_label' => esc_html__('Tambah Layanan', $textdomain))));

		$wp_customize->add_section('section_homelogo', array('panel' => 'panel_perusahaan', 'title' => __('Logo Home', $textdomain), 'priority' => 50));
		$wp_customize->add_setting('title_homelogo', array('default' => 'Klien Kami', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control('title_homelogo', array('type' => 'text', 'label' => __('Judul', $textdomain), 'section' => 'section_homelogo'));
		$wp_customize->add_setting('logo_repeater', array('default' => velocitychild_get_legacy_logo_items(), 'sanitize_callback' => 'velocitychild_sanitize_logo_repeater'));
		$wp_customize->add_control(new Velocitychild_Repeater_Control($wp_customize, 'logo_repeater', array('label' => esc_html__('Logo Home Control', $textdomain), 'section' => 'section_homelogo', 'priority' => 10, 'fields' => velocitychild_get_logo_repeater_fields(), 'item_label' => esc_html__('Logo', $textdomain), 'add_button_label' => esc_html__('Tambah Gambar', $textdomain))));

		$wp_customize->remove_panel('global_panel');
		$wp_customize->remove_panel('panel_header');
		$wp_customize->remove_panel('panel_footer');
		$wp_customize->remove_panel('panel_antispam');
		$wp_customize->remove_section('header_image');
	}
}

if (!function_exists('velocitychild_theme_setup')) {
	function velocitychild_theme_setup() {
		add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);
		remove_action('justg_header', 'justg_header_menu');
		remove_action('justg_do_footer', 'justg_the_footer_open');
		remove_action('justg_do_footer', 'justg_the_footer_content');
		remove_action('justg_do_footer', 'justg_the_footer_close');
		remove_theme_support('widgets-block-editor');
	}
}

add_action('wp_head', function () {
	if (!is_single()) {
		remove_action('justg_before_title', 'justg_breadcrumb');
	}
});

if (!function_exists('justg_header_open')) {
	function justg_header_open() {
		echo '<header id="wrapper-header">';
		echo '<div id="wrapper-navbar" class="p-0 border-bottom" itemscope itemtype="http://schema.org/WebSite">';
	}
}

if (!function_exists('justg_header_close')) {
	function justg_header_close() {
		echo '</div>';
		echo '</header>';
	}
}

add_action('widgets_init', 'remove_some_widgets', 11);
function remove_some_widgets() {
	unregister_sidebar('footer-widget-4');
}

add_action('justg_header', 'justg_header_berita');
function justg_header_berita() {
	require_once get_stylesheet_directory() . '/inc/part-header.php';
}

add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita() {
	require_once get_stylesheet_directory() . '/inc/part-footer.php';
}

add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content() {
}

add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content() {
}

add_filter('excerpt_more', 'velocity_custom_excerpt_more');
if (!function_exists('velocity_custom_excerpt_more')) {
	function velocity_custom_excerpt_more($more) {
		return '...';
	}
}

add_filter('excerpt_length', 'velocity_excerpt_length');
function velocity_excerpt_length($length) {
	return 20;
}

if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check() {
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

if (!function_exists('vdberita_limit_text')) {
	function vdberita_limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos   = array_keys($words);
			$text  = substr($text, 0, $pos[$limit]) . '...';
		}

		return $text;
	}
}
