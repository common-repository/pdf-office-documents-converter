<?php

get_header();
?>
<!-- #site-content -->
<main id="site-content" role="main">
	<?php
	
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}

	?>

</main><!-- #site-content -->


<?php get_footer(); ?>
