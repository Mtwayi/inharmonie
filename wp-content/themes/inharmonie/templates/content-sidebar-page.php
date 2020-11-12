<?php /* 
Template Name: Content Sidebar Page
*/ 
?>

<div class="content-sidebar-page">
 	<?php custom_fields(); ?>
	<div class="container section">
		<div class="col-sm-12 col-md-9">
			<?php the_content(); ?>
		</div>

		<div class="col-sm-12 col-md-3">
			<div class="content">
				<?php dynamic_sidebar('sidebar-primary'); ?>
			</div>
		</div>
	</div>
</div>
