<?php /* 
Template Name: Stories Template
*/ 
?>

<div class="content-sidebar-page">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div  class="row">
			<div class="col-sm-12 col-md-12 col-lg-9 left-side">
				<div class="blog-btns">
					<?php the_content(); ?>
				</div>

				<div class="listings">
				<div  class="row">

					<?php query_posts('post_type=story&post_status=publish&posts_per_page=-1'); ?>

					<?php if( have_posts() ): ?>

				        <?php while( have_posts() ): the_post(); ?>

				        	<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
					        	<div  class="row">
					        		<div class="col-sm-12 col-md-12">
							        	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("features-story2"); ?></a>
							        </div><!-- /#post-<?php get_the_ID(); ?> -->
							        <div class="col-sm-12 col-md-12">
							        	<div class="article"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
										<?php echo get_excerpt(140); ?>
							    	</div>
							    </div>
							</div>

				        <?php endwhile; ?>
				        
					<?php endif; wp_reset_query(); ?>
				</div>
				</div>

			</div>

			<div class="col-sm-12 col-md-12 col-lg-3 right-side">
				<div class="content">
					<?php dynamic_sidebar('sidebar-primary'); ?>
				</div>
			</div>
		</div>
	</div>
</div>