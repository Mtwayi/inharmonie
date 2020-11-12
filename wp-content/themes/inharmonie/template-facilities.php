<?php
/**
 * Template Name: Facilities
 */
?>

<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/page', 'header'); ?>
    <?php get_template_part('templates/content', 'page'); ?>

	<?php 
        $args = array( 
          'post_type' => 'facility',
          'orderby' => 'weight' ,
          'order' => 'ASC',
          'posts_per_page' => -1,
        );
        $the_query = new WP_Query( $args );
    ?>
    <div class="container">
        <div class="row">  
    		<div class="facilities_gallery">
                <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="fac_item">
        				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail() ?> </a>
                      	<div class="content">
                          	<p><?php the_title() ?></p>
                          	<a href="<?php the_permalink(); ?>" class="btn__white">View More</a>
        				</div>
                    </div>
                <?php endwhile;  endif; ?>
    		</div>
        </div>
    </div>
    <?php wp_reset_query(); ?>

<?php endwhile; ?>
