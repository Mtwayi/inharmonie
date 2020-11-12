<div class="content-sidebar-page leaders-article">
 	<?php /**custom_fields();*/ ?>
	<div class="container section">
		<div class="col-sm-12 col-md-12 col-lg-9 left-side">
			<div class="blog-btns">
				<p>
					<a class="btn transparent-green" href="http://localhost/inharmonie/stories/">Stories of Change</a>
					<a class="btn green" href="#">Leaders of Change</a>
				</p>
			</div>
			<?php while( have_posts() ): the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<h4><?php echo get_excerpt_without_readmore(500); ?></h4>
				<div class="author">
					<?php the_author(); ?> on <span class="entry-date"><?php echo get_the_date(); ?></span>
				</div>

				<div class="socials">
					<div class="col-sm-12">
						<div class="row">
							<?php echo do_shortcode("[wp_social_sharing social_options='facebook,twitter,googleplus,linkedin,pinterest' twitter_username='conversionadv' facebook_text='Share on Facebook' twitter_text='Share on Twitter' googleplus_text='Share on Google+' linkedin_text='Share on Linkedin' pinterest_text='Share on Pinterest' icon_order='f,t,g,l,p' show_icons='1' before_button_text='' text_position='' social_image='']"); ?>
						</div>
					</div>
				</div>

				<div class="thumbnail">
					<?php //the_post_thumbnail("full"); ?>
					<?php the_post_thumbnail( 'blog-article-banner' ); ?>
				</div>
				<div class="content">

					<?php the_content(); ?>

					<!-- https://www.cssigniter.com/ignite/programmatically-get-related-wordpress-posts-easily/ -->
					<?php
					$terms        = get_the_terms( get_the_ID(), 'post_tag' );
					if( $terms ):
						$term_list    = wp_list_pluck( $terms, 'slug' );
						$related_args = array(
						  'post_type'      => 'leader',
						  'posts_per_page' => 2,
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
							        		<div class="summary"><?php echo get_excerpt_button_green(140); ?></div>
							        	</div>
							        <!-- </div> -->
						        </div>
						      <?php endwhile; ?>
						  </div>
						<?php endif; ?>
					<?php endif; ?>



				</div>
			<?php endwhile; ?>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>
