<div class="content-sidebar-page events-article">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">

			<?php while( have_posts() ): the_post(); ?>
				
				<?php event_fields(); ?>

				<div class="content">

					<!-- https://www.cssigniter.com/ignite/programmatically-get-related-wordpress-posts-easily/ -->
					<?php
					$terms        = get_the_terms( get_the_ID(), 'post_tag' );
					if( $terms ):
						$term_list    = wp_list_pluck( $terms, 'slug' );
						$related_args = array(
						  'post_type'      => 'event',
						  'posts_per_page' => -1,
						  'post_status'    => 'publish',
						  'post__not_in'   => array( get_the_ID() ),
						  'tax_query'      => array(
						    array(
						      'taxonomy' => 'post_tag',
						      'field'    => 'slug',
						      'terms'    => $term_list
						    )
						  )
						);

						$related = new WP_Query( $related_args );

						if( $related->have_posts() ):
						?>
						  <div class="related-articles">
						    <div class="related">Related Articles</div>
						      <?php while( $related->have_posts() ): $related->the_post(); ?>
						        <div class="col-sm-12 col-md-6 cols">
						        	<!-- <div class="row"> -->
							        	<div class="article">
							        		<?php the_post_thumbnail( 'blog-ralated' ); ?>
							        		<div class="title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							        		<div class="summary"><?php echo get_excerpt(140); ?></div>
							        	</div>
							        <!-- </div> -->
						        </div>
						      <?php endwhile; ?>
						  </div>
						<?php endif; ?>
					<?php endif; ?>



				</div>
			<?php endwhile; ?>

			<div class="ticket__book">
				<?php gravity_form(18, false, false, false, '', true, 12); ?>
			</div>

		</div>
		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('primary-2'); ?>
			</div>
		</div>
	</div>
</div>
