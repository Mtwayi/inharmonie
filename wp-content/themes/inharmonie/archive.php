<div class="content-sidebar-page">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<?php the_content(); ?>

			<div class="listings">

				<?php query_posts('post_type=post&post_status=publish&posts_per_page=5&paged='. get_query_var('paged')); ?>

				<?php if( have_posts() ): ?>

			        <?php while( have_posts() ): the_post(); ?>

			        	<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
				        	<div  class="row">
				        		<div class="col-sm-12 col-md-4">
						        	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(260,260) ); ?></a>
						        </div><!-- /#post-<?php get_the_ID(); ?> -->
						        <div class="col-sm-12 col-md-8">
						        	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php the_excerpt(__('Continue reading »','example')); ?>
									<i class="fa-chevron-right"></i>
						    	</div>
						    </div>
						</div>

			        <?php endwhile; ?>

					<div class="navigation">
						<span class="newer"><?php previous_posts_link(__('« Newer','example')) ?></span> <span class="older"><?php next_posts_link(__('Older »','example')) ?></span>
					</div><!-- /.navigation -->

				<?php else: ?>

					<div id="post-404" class="noposts">
					    <p><?php _e('None found.','example'); ?></p>
				    </div><!-- /#post-404 -->

				<?php endif; wp_reset_query(); ?>

			</div>

		</div>

		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>