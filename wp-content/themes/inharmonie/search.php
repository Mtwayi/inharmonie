<div class="content-sidebar-page">
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<header class="page-header">
                <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'shape' ), '<span>"' . get_search_query() . '"</span>' ); ?></h1>
            </header><!-- .page-header -->
			<div class="listings">

				<?php get_template_part('templates/page', 'header'); ?>

				<?php if (!have_posts()) : ?>
				  <div class="alert alert-warning">
				    <?php _e('Sorry, no results were found.', 'sage'); ?>
				  </div>
				  <?php get_search_form(); ?>
				<?php endif; ?>

				<?php while (have_posts()) : the_post(); ?>
				  <?php get_template_part('templates/content', 'search'); ?>
				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			</div>
		</div>
		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>
