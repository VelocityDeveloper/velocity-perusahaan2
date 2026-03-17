<?php

/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row m-0">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main col order-2" id="main">
                <?php
                if (have_posts()) {
                ?>
                    <header class="page-header block-primary">
                        <?php
                        the_archive_title('<h1 class="page-title text-uppercase">', '</h1>');
                        the_archive_description('<div class="taxonomy-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->
                    <?php
                    // Start the loop.
                    $postcount = 1;
                    while (have_posts()) {
                        the_post();
                    ?>
                        <article class="block-primary border-bottom mb-4 pb-3">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="post-tumbnail position-relative">
										<?php echo velocitychild_get_post_thumbnail_html(get_the_ID(), array('ratio' => '16x9')); ?>
                                    </div>
                                </div>
                                <div class="col px-md-0 p-2">
                                    <div class="post-text">
                                        <?php $categories = get_the_category(get_the_ID()); ?>
                                        <small class="text-capitalize">
                                            <?php foreach ($categories as $index => $cat) : ?>
                                                <?php echo $index === 0 ? '' : ','; ?>
                                                <a class="color-theme fw-bold" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"> <?php echo esc_html($cat->name); ?> </a>
                                                <?php if ($index > 1) {
                                                    break;
                                                } ?>
                                            <?php endforeach; ?>
                                        </small>
                                        <small class="ms-2" style="color:#787878;">
                                            <?php echo get_the_date(); ?>
                                        </small>
                                        <?php the_title(sprintf('<h2 class="h6 mb-md-2 fw-bold"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                                            '</a></h2>');?>
                                        <div class="post-excerpt text-muted">
                                            <?php echo vdberita_limit_text(strip_tags(get_the_content()), 30); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>

                <?php
                        $postcount++;
                    }
                } else {
                    get_template_part('loop-templates/content', 'none');
                }
                ?>
                <!-- Display the pagination component. -->
                <?php justg_pagination(); ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
