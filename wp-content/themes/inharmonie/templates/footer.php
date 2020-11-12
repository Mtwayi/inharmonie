
<?php //case_study_projects(); ?>

<?php if ( is_singular( 'services' ) ) : ?>

	<?php services_before_related_projects(); ?>

    <?php

        $q_object = get_queried_object();
        //print_r($q_object);

        if ( isset($q_object->post_name) ) {

            $service_category = $q_object->post_name;

            if( $service_category == 'adwords' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'adwords'
                        )
                    )
                );
            } else if( $service_category == 'brand-design' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'brand-design'
                        )
                    )
                );
            } else if( $service_category == 'digital-marketing' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'digital-marketing'
                        )
                    )
                );
            } else if( $service_category == 'seo' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'seo'
                        )
                    )
                );
            } else if( $service_category == 'social-media-marketing' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'social-media-marketing'
                        )
                    )
                );
            } else if( $service_category == 'website-design' ) {
                $related_args = array(
                    'post_type'      => 'case-studies',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'filter',
                            'field'    => 'slug',
                            'terms'    => 'website-design'
                        )
                    )
                );
            }
        }

        $related = new WP_Query( $related_args );

        if( $related->have_posts() ):
        ?>
            <div class="related-articles">
                <div class="container">
                    <div class="related">Our Work</div>
                    <?php while( $related->have_posts() ): $related->the_post(); ?>
                        <div class="col-sm-12 col-md-4 cols">
                            <!-- <div class="row"> -->
                            <div class="article">
                                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'case-study-ralated' ); ?></a>
                                <div class="title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                <div class="summary"><?php echo get_excerpt_without_readmore(140); ?></div>
                            </div>
                            <!-- </div> -->
                      </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif;
    ?>

<?php endif; ?>


<footer class="content-info">
  <div class="container">
  	<div class="row">
    	<?php dynamic_sidebar('sidebar-footer'); ?>
    </div>
  </div>
</footer>

<div id="copywrite">
	<div class="container">
		<?php dynamic_sidebar( 'bottom_bar' ); ?>
	</div>
</div>
