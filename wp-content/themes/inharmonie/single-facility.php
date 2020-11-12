<div class="content-sidebar-page stories-article">
 	<?php /**custom_fields();*/ ?>
	<div class="container section">
		<div class="col-sm-12 col-md-12 col-lg-9 left-side">
			<?php while( have_posts() ): the_post(); ?>
				<h1><?php the_title(); ?></h1>
			
				<div class="content">

					<?php the_content(); ?>

				</div>
			<?php endwhile; ?>

			<div class="single_facility_gallery">

				<?php 

				$images = get_field('fac_gallery');

				if( $images ): ?>
				    <ul>
				        <?php foreach( $images as $image ): ?>
				            <li>
				               
				                     <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
				              
				            </li>
				        <?php endforeach; ?>
				    </ul>
				<?php endif; ?>

			</div>

		</div>
		<div class="col-sm-12 col-md-12 col-lg-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>
