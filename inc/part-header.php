<div class=" bg-theme">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div class="text-start text-md-end py-3">
                    <?php
                    $notel = velocitytheme_option('notel', '');
                    if ($notel) {
                        echo '<span class="rounded-circle bg-light text-color-theme p-2 me-2"><span class="dashicons dashicons-phone"></span></span>';
                        echo '<a href="tel:'.$notel.'" class="text-decoration-none text-light">'.$notel.'</a>';
                    }
                    ?>  
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-start py-3">
                    <?php
                    $email = velocitytheme_option('email', '');
                    if ($email) {
                        echo '<span class="rounded-circle bg-light text-color-theme p-2 me-2"><span class="dashicons dashicons-email-alt"></span></span>';
                        echo '<a href="mailto:'.$email.'" class="text-decoration-none text-light">'.$email.'</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <div class="row align-items-center">
        <div class="col-md-3 col-9">
            <div class="text-start">
                <?php
                $logo = velocitytheme_option('custom_logo', '');
                if ($logo) {
                    $logo = wp_get_attachment_image_url($logo, 'full');
                    echo '<a href="'.get_home_url().'">';
                        echo '<img src="'.esc_url($logo).'" alt="'.esc_attr(get_bloginfo('name')).'" />';
                    echo '</a>';
                } else {
                    echo '<h1 class="site-title"><a href="'.get_home_url().'" rel="home">'.esc_html(get_bloginfo('name')).'</a></h1>';
                }
                ?>
            </div>
        </div>
        <div class="col-md-9 col-3">
            <nav id="main-navi" class="navbar navbar-expand-md d-block navbar-light p-0" aria-labelledby="main-nav-label">

                <h2 id="main-nav-label" class="screen-reader-text">
                    <?php esc_html_e('Main Navigation', 'justg'); ?>
                </h2>

                <div class="w-100">
                    <?php if (has_header_image()) {
                        echo '<a href="'.get_home_url().'">';
                            echo '<img class="w-100" src="'.esc_url(get_header_image()).'" />';
                        echo '</a>';
                    } ?>
                </div>
                <div class="pb-0">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">
                        <div class="offcanvas-header justify-content-end">
                            <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div><!-- .offcancas-header -->

                        <!-- The WordPress Menu goes here -->
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'primary',
                                'container_class' => 'offcanvas-body',
                                'container_id'    => '',
                                'menu_class'      => 'navbar-nav navbar-light justify-content-end flex-md-wrap flex-grow-1',
                                'fallback_cb'     => '',
                                'menu_id'         => 'primary-menu',
                                'depth'           => 4,
                                'walker'          => new justg_WP_Bootstrap_Navwalker(),
                            )
                        ); ?>
                    </div><!-- .offcanvas -->
                </div>

                <div class="menu-header d-md-none position-relative text-end" data-bs-theme="dark">
                    <button class="navbar-toggler bg-theme rounded-1 p-2 text-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </div>

            </nav><!-- .site-navigation -->
        </div>
    </div>
</div>