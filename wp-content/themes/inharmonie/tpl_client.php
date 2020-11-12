<?php /* 
Template Name: Client Posts
*/ 
?>

<div class="content-page">
 	<?php custom_fields(); ?>
	<div class="container section">
		<?php the_content(); ?>

		<div class="client-listings">

			<?php query_posts('post_type=post&cat=clients&post_status=publish&posts_per_page=-1'); ?>

			<?php if( have_posts() ): ?>

		        <?php while( have_posts() ): the_post(); ?>

	        		<!-- <div class="col-xs-6 col-sm-6 col-md-3 cell"> -->
	        		<div class="cell">
			        	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("full"); ?></a>
			        </div>

		        <?php endwhile; ?>

			<?php endif; wp_reset_query(); ?>

		</div>
	</div>
</div>