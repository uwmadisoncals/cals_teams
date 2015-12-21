<?php get_header(); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		include( WP_PLUGIN_DIR . '/cals_teams/includes/data/cals_teams_fields.php' );


		$fob = $field_office_location['name'];
		logit($fob,'$fob');

		$mbox_fields = $mbox['fields'];
		logit($mbox_fields,'$mbox_fields');


		$args = array('post_type'=>'team');
		$cals_teams_query = new WP_Query($args);
		// Start the loop.
		while ( have_posts() ) : the_post();

		echo 'THIS IS TEMPLATE FROM Plugin';

		$plugin_template_obj = new Cals_Teams;

		$meta = $plugin_template_obj->filter_meta_array();

			logit($meta,'$meta: ');
			logit($cals_teams_query, '$cals_teams_query');

/*			//This is bad b/c I want to display label&data without needing to know meta key
			if( isset($meta['calsteams_office_location_2']) ){
				echo $meta['calsteams_office_location_2'][0] ;
			}*/

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			//get_template_part( 'content', get_post_format() );
			

			//////////////////////// INNER CONTENT ////////////////////////////////
			?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				// Post thumbnail.
				twentyfifteen_post_thumbnail();
			?>

			<header class="entry-header">
				<?php
					if ( is_single() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					endif;
				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
/*					//Display cals team fields
					foreach ($meta as $key => $value) {

					logit($key,'$key: ');//this variable works, returns things like _edit_last_, calsteams_office_location, etc

					switch($key){
						case 'calsteams_office_location':
						echo "Office Location: " . $value[0];
						break;

					default:
						continue;
					}

					//echo $key . '';
					//echo $key[$value] . '<br>';
				}*/

				foreach ($mbox_fields as $key => $value) {
					$id = $value['id'];

					echo '<div class="team-item"><span class="team-item-label">';
					echo $value['name'] . ': ';
					echo '</span>';

					echo '<span class="team-item-value">';
					echo $meta[$id][0];
					echo '</span></div>';


				}



					/* translators: %s: Name of current post */
					the_content( sprintf(
						__( 'Continue reading %s', 'twentyfifteen' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
			</div><!-- .entry-content -->

			<?php
				// Author bio.
				if ( is_single() && get_the_author_meta( 'description' ) ) :
					get_template_part( 'author-bio' );
				endif;
			?>

			<footer class="entry-footer">
				<?php twentyfifteen_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->

		</article><!-- #post-## -->
		<?php 
			
			/////////////////////////// END INNER CONTENT /////////////////////////////////

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