<?php 
//THIS IS A SAMPLE TEMPLATE. To use it follow these directions:
// 1. Create a Directory in the root level of your theme named exactly 'cals_teams_templates'
// 2. Copy This Theme into said directory, keep the file name single.php
// 3.
get_header(); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$args = array('post_type'=>'team');
		$cals_teams_query = new WP_Query($args);
		// Start the loop.
		while ( have_posts() ) : the_post();

		//Uncomment to debug template origin
		//echo 'THIS IS TEMPLATE FROM THEME';

		$myObj = new Cals_Teams;
		$meta = apply_filters( 'theme_calsteams_get_post_meta', FALSE );

		$mbox_fields = $mbox['fields'];
		//logit($mbox_fields,'$mbox_fields');

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			//get_template_part( 'content', get_post_format() );
			//
			//////////////////////////
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				// Post thumbnail.

				if(has_post_thumbnail()){

					the_post_thumbnail('full');
				}
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
				foreach ($mbox_fields as $key => $value) {
					$id = $value['id'];
					if(array_key_exists($id,$meta)){
						echo '<div class="team-item"><span class="team-item-label">';
						echo $value['name'] . ': ';
						echo '</span>';

						echo '<span class="team-item-value">';
						
						echo $meta[$id][0];
						
						echo '</span></div>';
					}
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
				<?php if(function_exists('twentyfifteen_entry_meta')){
				twentyfifteen_entry_meta();
				} ?>
				<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->

		</article><!-- #post-## -->
		<?php 
			

			////////////////////////////
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