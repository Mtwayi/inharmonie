<?php
/**
 * Template Name: Content Header Page
 */
?>

<div class="content-header-page">
	<div class="header-title">
		<div class="container">
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
			    <?php if(function_exists('bcn_display')){
			        bcn_display();
			    }?>
			</div>

			<h1><?php the_title(); ?></h1>

		</div>
	</div>

	<div class="content-wrap">
		<?php custom_fields(); ?> <?php // *** Pulling through fields from BASE.php ***/ ?>
	</div>
</div>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
	
	<?php if ($post->post_content != "") : ?> <?php // *** Checking to see if the default content area in wordpress has content ***/ ?>
		<div class="bottom-wrap"> <?php // *** Fields at the bottom of the page - pulls through from the default content area in wordpress ***/ ?>
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div>					

	<?php else : ?>

	<?php endif; ?>	

<?php endwhile; ?> 
<?php else : ?>	

<?php endif; ?>