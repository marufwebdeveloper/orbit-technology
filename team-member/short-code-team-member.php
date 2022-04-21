<?php 

$posts_per_page = $params['number_of_member']?:5;
$image_position =  $params['image_position'];
$show_more_button = $params['view_more_button'];


$posts = new WP_Query([
	'post_type' => ss00_settings('post_type_url'),
	'posts_per_page' => $posts_per_page
]);

while ( $posts->have_posts() ) : 
  	$posts->the_post();

  	$img = "<div class='img'><img src='".get_the_post_thumbnail_url()."' style='max-width: 100%;'/></div>";
 ?>
<a href="<?php the_permalink(); ?>">
	<div class="etmia">
		<?php 
			if($image_position=='top' || !$image_position) echo $img;
		?>
		
		<div>
			<h3><?php the_title(); ?></h3>
		</div>
		<?php 
			if($image_position=='bottom') echo $img;
		?>
	</div>
</a>
<?php 
endwhile;

	if($show_more_button=='show'){
		echo "<div style='text-align:center'><a href='".get_post_type_archive_link(ss00_settings('post_type_url'))."'>View All</a></div>";
	}

 ?>