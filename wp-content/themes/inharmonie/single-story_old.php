<div class="content-sidebar-page stories-article">
 	<?php /**custom_fields();*/ ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<div class="blog-btns">
				<p>
					<a class="btn green" href="#">Stories of Change</a>
					<a class="btn transparent-green" href="http://conversionadvantage-staging.com/inharmonie/leaders/">Leaders of Change</a>
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

				<?php 
					$classname = 'no-thumb';
					if (!class_exists($classname)): 
				?>
					<div class="thumbnail">
						<?php //the_post_thumbnail("full"); ?>
						<?php //the_post_thumbnail( 'blog-article-banner' ); ?>
					</div>
				<?php endif; ?>
				<div class="content">

					<?php the_content(); ?>

					<!--BEGIN .author-bio-->
					<div class="author-bio">
						<div class="col-sm-12 col-md-3">
							<div class="row">
								<div class="author-pic">
									<?php echo get_avatar( get_the_author_meta('email'), '180' ); ?>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-9">
							<div class="row">
								<div class="author-info">
									<h3 class="author-title">About the author: <span><?php the_author(); ?></span></h3>
									<p class="author-description"><?php the_author_meta('description'); ?></p>
									<!-- <p>Other posts by <?php the_author_posts_link(); ?></p> -->
									<!-- <?php
										$user_url = get_the_author_meta( 'user_url' );
										if ( $user_url && $user_url != '' ) {  ?>
											<p>Website: <a href="<?php the_author_meta('user_url');?>"><?php the_author_meta('user_url');?></a></p>
									<?php } ?>
									<ul class="icons">
										<?php
											$rss_url = get_the_author_meta( 'rss_url' );
											if ( $rss_url && $rss_url != '' ) {
												echo '<li class="rss"><a href="' . esc_url($rss_url) . '"></a></li>';
											}

											$google_profile = get_the_author_meta( 'google_profile' );
											if ( $google_profile && $google_profile != '' ) {
												echo '<li class="google"><span>Google Profile:</span> <a href="' . esc_url($google_profile) . '" rel="author">' . esc_url($google_profile) . '</a></li>';
											}

											$twitter_profile = get_the_author_meta( 'twitter_profile' );
											if ( $twitter_profile && $twitter_profile != '' ) {
												echo '<li class="twitter"><span>Twitter Profile:</span> <a href="' . esc_url($twitter_profile) . '">' . esc_url($twitter_profile) . '</a></li>';
											}

											$facebook_profile = get_the_author_meta( 'facebook_profile' );
											if ( $facebook_profile && $facebook_profile != '' ) {
												echo '<li class="facebook"><span>Facebook Profile:</span> <a href="' . esc_url($facebook_profile) . '">' . esc_url($facebook_profile) . '</a></li>';
											}

											$linkedin_profile = get_the_author_meta( 'linkedin_profile' );
											if ( $linkedin_profile && $linkedin_profile != '' ) {
												echo '<li class="linkedin"><span>Linkedin Profile:</span> <a href="' . esc_url($linkedin_profile) . '">' . esc_url($linkedin_profile) . '</a></li>';
											}
										?>
									</ul> -->
								</div>
							</div>
						</div>
					</div>
					<!--END .author-bio-->


					<!-- https://www.cssigniter.com/ignite/programmatically-get-related-wordpress-posts-easily/ -->
					<?php
					$terms        = get_the_terms( get_the_ID(), 'post_tag' );
					if( $terms ):
						$term_list    = wp_list_pluck( $terms, 'slug' );
						$related_args = array(
						  'post_type'      => 'story',
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
		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>
