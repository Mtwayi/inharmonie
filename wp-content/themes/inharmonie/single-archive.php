<div class="content-sidebar-page stories-article">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9 left-side">
			<?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>
		</div>
		<div class="col-sm-12 col-md-3 right-side">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>