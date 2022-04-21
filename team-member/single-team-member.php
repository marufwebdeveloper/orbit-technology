<?php 

get_header();

while ( have_posts() ) :
	the_post();
?>

<table style='width:100%'>
	<tr>
		<td>
			<h3><?php the_title(); ?></h3>
			<p>
				<span>
					Position : 
				</span>
				<span>
					<?php			
						echo get_post_meta( get_the_id(), 'team-member-position', true );
					?>			 	
			 	</span>	
			</p>
			<p>
				<i>
				<span>Member Type : </span>
				
					<?php 
						$m_t = get_the_terms( get_the_id(), ss00_settings('taxonomy_url') );
						$_mt = '';
						if($m_t){
							foreach ( $m_t as $mt ) {
						  		$_mt .= $_mt?', '.$mt->name:$mt->name;
							}
						}
						
						echo $_mt;
					?>
				</i>
			</p>
		</td>
		<td style='width: 200px;'>
			<img src='<?php the_post_thumbnail_url() ?>' style='max-width: 100%;'/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<hr/>
			<?php 
				the_content();
			?>
		</td>
	</tr>

</table>

<?php
endwhile; 


get_footer();