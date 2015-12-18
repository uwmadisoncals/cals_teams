<?php get_header(); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		$args = array('post_type'=>'cals_team_members');
		$cals_teams_query = new WP_Query($args);
		// Start the loop.
		while ( have_posts() ) : the_post();

			$meta = get_post_custom(get_the_ID());

			logit($meta,'$meta: ');
			logit($cals_teams_query, '$cals_teams_query');

/*			//This is bad b/c I want to display label&data without needing to know meta key
			if( isset($meta['calsteams_office_location_2']) ){
				echo $meta['calsteams_office_location_2'][0] ;
			}*/

			foreach ($meta as $key => $value) {
/*				echo "key: $key, value: $value[0] <br>";

				if($key =='calsteams_office_location'){
					echo "Office Location: " . $value[0]; 
				}*/

				switch($key){
					case 'calsteams_office_location':
					echo "Office Location: " . $value[0];
					break;

				default:
					continue;
				}

				//echo $key . '';
				//echo $key[$value] . '<br>';
			}

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
	
<?php get_footer(); ?>