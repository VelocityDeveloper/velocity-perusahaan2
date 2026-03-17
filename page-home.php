<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 *
 * @package justg
 */

get_header();

$banner_image = velocitychild_resolve_image_value_to_url(velocitytheme_option('home_banner', 0), 'full');
if (!$banner_image) {
	$banner_image = trailingslashit(get_stylesheet_directory_uri()) . 'img/homebanner.webp';
}

$subtitle_banner = (string) velocitytheme_option('subtitle_banner', 'Selamat Datang di');
$title_banner    = (string) velocitytheme_option('title_banner', 'Perusahaan 2<br>Velocity Developer');
$content_banner  = (string) velocitytheme_option('content_banner', '');
$button1_banner  = (string) velocitytheme_option('button1_banner', 'Hubungi Kami');
$link1_banner    = (string) velocitytheme_option('link1_banner', '#');
$button2_banner  = (string) velocitytheme_option('button2_banner', 'Layanan');
$link2_banner    = (string) velocitytheme_option('link2_banner', '#');
$sambutan        = (string) velocitytheme_option('sambutan', '');
$sambutan_image  = velocitychild_resolve_image_value_to_url(velocitytheme_option('sambutan_image', 0), 'full');
$layanan_items   = velocitychild_get_home_layanan_items();
$title_homelogo  = (string) velocitytheme_option('title_homelogo', 'Klien Kami');
$logo_items      = velocitychild_get_home_logo_items();
?>

<div class="home-wrapper" id="page-wrapper">
	<div class="banner-area">
		<div class="banner-image position-relative m-0 p-md-5 p-3" style="background-image: url('<?php echo esc_url($banner_image); ?>');">
			<div class="container row m-auto align-items-center my-5">
				<div class="col-md-6 text-white" style="position: relative; z-index: 99;">
					<?php if ($subtitle_banner) : ?>
						<h6 class="subtitle"><?php echo esc_html($subtitle_banner); ?></h6>
					<?php endif; ?>
					<?php if ($title_banner) : ?>
						<h1 class="title"><?php echo wp_kses_post($title_banner); ?></h1>
					<?php endif; ?>
					<?php if ($content_banner) : ?>
						<div class="description text-justify">
							<?php echo wp_kses_post($content_banner); ?>
						</div>
					<?php endif; ?>
					<div class="d-flex justify-content-start flex-wrap gap-2 mt-4">
						<?php if ($button1_banner) : ?>
							<a href="<?php echo esc_url($link1_banner); ?>" class="text-uppercase fw-bold btn btn-md btn-light rounded-1 text-color-theme" style="min-width: 150px;"><?php echo esc_html($button1_banner); ?></a>
						<?php endif; ?>
						<?php if ($button2_banner) : ?>
							<a href="<?php echo esc_url($link2_banner); ?>" class="text-uppercase fw-bold btn btn-md btn-light rounded-1 text-color-theme" style="min-width: 150px;"><?php echo esc_html($button2_banner); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md-6 d-none d-md-block"></div>
			</div>
		</div>
	</div>

	<?php if ($sambutan || $sambutan_image) : ?>
		<div class="container py-5">
			<div class="row m-0 align-items-center">
				<div class="col-md-8 col-12 order-md-1 order-2">
					<?php if ($sambutan) : ?>
						<div class="sambutan-home"><?php echo wp_kses_post($sambutan); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-md-4 col-12 order-md-2 order-1 p-md-0">
					<?php if ($sambutan_image) : ?>
						<div class="sambutan-image text-center mb-3">
							<img class="rounded-4 p-0" src="<?php echo esc_url($sambutan_image); ?>" alt="">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!empty($layanan_items)) : ?>
		<div class="frame-layanan pt-2">
			<div class="container py-5">
				<?php $layanan_col_class = count($layanan_items) > 5 ? 'col-lg-4 col-md-6 col-12' : 'col-lg col-md-6 col-12'; ?>
				<div class="row m-0 justify-content-center">
					<?php foreach ($layanan_items as $item) : ?>
						<?php
						$image     = isset($item['layanan_image']) ? $item['layanan_image'] : '';
						$image_url = velocitychild_resolve_image_value_to_url($image, 'medium');
						if (!$image_url) {
							$image_url = velocitychild_get_no_image_url();
						}
						$title    = isset($item['layanan_title']) ? (string) $item['layanan_title'] : '';
						$content  = isset($item['layanan_content']) ? (string) $item['layanan_content'] : '';
						$linktext = isset($item['layanan_linktext']) ? (string) $item['layanan_linktext'] : '';
						$link     = isset($item['layanan_link']) ? (string) $item['layanan_link'] : '';
						?>
						<div class="<?php echo esc_attr($layanan_col_class); ?> mb-3 px-md-3">
							<div class="card card-layanan bg-theme border-0 text-light rounded-3 shadow-sm h-100">
								<div class="card-body text-center">
									<img src="<?php echo esc_url($image_url); ?>" class="rounded-circle velocity-layanan-image" alt="<?php echo esc_attr($title); ?>">
									<div class="p-2">
										<?php if ($title) : ?>
											<h3 class="card-title fw-bold my-3"><?php echo esc_html($title); ?></h3>
										<?php endif; ?>
										<?php if ($content) : ?>
											<div class="card-text text-start text-justify"><?php echo wp_kses_post($content); ?></div>
										<?php endif; ?>
										<?php if ($link) : ?>
											<a href="<?php echo esc_url($link); ?>" class="text-capitalize text-light btn-hubungi btn btn-md rounded-0 border mt-3" style="min-width: 150px;"><?php echo esc_html($linktext ? $linktext : __('Selengkapnya', 'justg')); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($title_homelogo || !empty($logo_items)) : ?>
		<div class="container py-5">
			<?php if ($title_homelogo) : ?>
				<h3 class="text-center fw-bold text-uppercase"><?php echo esc_html($title_homelogo); ?></h3>
			<?php endif; ?>
			<?php if (!empty($logo_items)) : ?>
				<div class="slider-logo">
					<?php foreach ($logo_items as $item) : ?>
						<div class="logo-item text-center p-2">
							<img src="<?php echo esc_url($item['logo_image_url']); ?>" alt="">
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div><!-- #page-wrapper -->

<?php
get_footer();
