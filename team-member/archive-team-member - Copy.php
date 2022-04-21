
<?php 

get_header();


while ( have_posts() ) :
	the_post();
?>
<a href="<?php the_permalink(); ?>">
	<div class="etmia">
		<div class="img">
			<img src='<?php the_post_thumbnail_url() ?>' style='max-width: 100%;'/>
		</div>
		<div>
			<h3><?php the_title(); ?></h3>
		</div>
	</div>
</a>
<?php
endwhile; 


get_footer();