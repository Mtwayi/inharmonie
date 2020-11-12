<div class="content-sidebar-page">
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<header class="page-header">
                <h1 class="page-title">404 Page</h1>
            </header><!-- .page-header -->
			<?php get_template_part('templates/page', 'header'); ?>
			<div class="alert alert-warning">
			  <?php _e('Sorry, but the page you were trying to view does not exist.', 'sage'); ?>
			</div>

			<?php /*get_search_form();*/ ?>
		</div>
		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>