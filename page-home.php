<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();
$container         = velocitytheme_option('justg_container_type', 'container');
?>

<div class="home-wrapper" id="page-wrapper">
    <div class="banner-area">
        <?php
            $banner = velocitytheme_option('home_banner', '');
            if ($banner) {
                $url_banner = wp_get_attachment_image_url($banner, 'full');
            } else {
                $url_banner = get_stylesheet_directory_uri() . '/img/homebanner.webp';
            }
        ?>
        <div class="banner-image position-relative m-0 p-md-5 p-3" style="min-height:550px; background-image: url('<?php echo esc_url($url_banner); ?>');">
            <div class="container row m-auto align-items-center my-5">
                <div class="col-md-6 text-white"style="position: relative;z-index: 99;">
                    <h6 class="subtitle"><?php echo velocitytheme_option('subtitle_banner');?></h6>
                    <h1 class="title"><?php echo velocitytheme_option('title_banner');?></h1>
                    <div class="description text-justify">
                        <?php echo velocitytheme_option('content_banner');?>
                    </div>
                    <div class="d-flex justify-content-center justify-content-md-start mt-4">
                        <a href="<?php echo esc_url(velocitytheme_option('link1_banner')); ?>" class="text-uppercase fw-bold btn btn-md btn-light rounded-1 text-color-theme me-3" style="min-width: 150px;"><?php echo velocitytheme_option('button1_banner');?></a>
                        <a href="<?php echo esc_url(velocitytheme_option('link2_banner')); ?>" class="text-uppercase fw-bold btn btn-md btn-light rounded-1 text-color-theme" style="min-width: 150px;"><?php echo velocitytheme_option('button2_banner');?></a>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">

                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row m-0 align-items-center">
            <div class="col-md-8 col-12 order-md-1 order-2">
                <?php $sambutan = velocitytheme_option('sambutan');
                    if ($sambutan) {
                        echo '<div class="sambutan-home">'.$sambutan.'</div>';
                    }
                ?>
            </div>
            <div class="col-md-4 col-12 order-md-2 order-1 p-md-0">
                <?php $sambutan_image = velocitytheme_option('sambutan_image');
                    if ($sambutan_image) {
                        echo '<div class="sambutan-image text-center mb-3">';
                            echo '<img class="rounded-4 p-0" src="' . wp_get_attachment_image_url($sambutan_image, 'full') . '"/>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div><!-- .container -->

    <div class="frame-layanan">
        <div class="container py-5">
            <?php $layanan= velocitytheme_option('layanan_repeater');
            // echo '<pre>'.print_r($layanan, true).'</pre>';
            ?>
            <div class="row m-0">
                <?php
                if ($layanan) {
                    foreach ($layanan as $item) {
                        echo '<div class="col-md-4 col-12 mb-3 px-3">';
                            echo '<div class="card card-layanan bg-theme border-0 text-light rounded-3 shadow-sm h-100">';
                                echo '<div class="card-body text-center">';
                                    echo '<img src="' . wp_get_attachment_image_url($item['layanan_image'], 'full') . '" class="rounded-circle" width="150" height="150" alt="' . esc_attr($item['layanan_title']) . '"/>';
                                    echo '<div class="p-2">';
                                        echo '<h3 class="card-title fw-bold my-3">' . esc_html($item['layanan_title']) . '</h3>';
                                        echo '<p class="card-text">' . esc_html($item['layanan_content']) . '</p>';
                                        echo '<a href="' . esc_url($item['layanan_link']) . '" class="text-capitalize text-light btn-hubungi btn btn-md rounded-0 border" style="min-width: 150px;">' . esc_html($item['layanan_linktext']) . '</a>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div><!-- .container -->
    </div>

    <div class="container py-5">
        <h3 class="text-center fw-bold text-uppercase"><?php echo velocitytheme_option('title_homelogo');?></h3>
        <?php $logo = velocitytheme_option('logo_repeater');?>
        <div class="slider-logo">
            <?php
            if ($logo) {
                foreach ($logo as $item) {
                    echo '<div class="logo-item text-center p-2">';
                        echo '<img src="' . wp_get_attachment_image_url($item['logo_image'], 'full') . '" class="" alt=""/>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div><!-- .container -->

</div><!-- #page-wrapper -->

<?php
get_footer();
