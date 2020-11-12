<div class="content-sidebar-page">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<div class="newsletter"><?php echo do_shortcode("[mc4wp_form id='360']"); ?></div>
			<div class="listings">

 				<?php $term_slug = get_query_var( 'term' ); ?>
				<?php query_posts('taxonomy=storiesfilter&term='.$term_slug.'&post_type=story&post_status=publish&posts_per_page=-1&paged='. get_query_var('paged')); ?>

				<?php if( have_posts() ): ?>

			        <?php while( have_posts() ): the_post(); ?>

			        	<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
				        	<div  class="row">
				        		<div class="col-sm-12 col-md-4">
						        	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(260,260) ); ?></a>
						        </div>
						        <div class="col-sm-12 col-md-8">
						        	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php echo get_excerpt(140); ?>
						    	</div>
						    </div>
						</div>

			        <?php endwhile; ?>

				<?php else: ?>

					<div id="post-404" class="noposts">
					    <p><?php _e('None found.','example'); ?></p>
				    </div><!-- /#post-404 -->

				<?php endif; wp_reset_query(); ?>

			</div>

		</div>

		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('primary-2'); ?>
			</div>
		</div>
	</div>
</div>