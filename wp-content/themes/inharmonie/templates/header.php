<?php
  // This file assumes that you have included the nav walker from https://github.com/twittem/wp-bootstrap-navwalker
  // somewhere in your theme.
?>

<header class="banner navbar navbar-default" role="banner">
    <div class="container">
        <!-- <div class="row"> -->
            <div class="navbar-header">
                <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo.png" /></a>
                <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-controls="exCollapsingNavbar2" aria-expanded="false" aria-label="Toggle navigation">
                    &#9776;
                </button>
            </div>

            <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
                <?php
                    if (has_nav_menu('primary_navigation')) :
                        wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'nav navbar-nav']);  
                    endif;
                ?>
            </div>
        <!-- </div> -->
    </div>
</header> 