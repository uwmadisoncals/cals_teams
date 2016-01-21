
<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		 	//Uncomment this to debug template origin
			echo 'This template is from plugin. archive-team.php';

			include( WP_PLUGIN_DIR . '/cals_teams/includes/data/cals_teams_fields.php' ); //include Metabox and Metabox field group data

		
		$mbox_fields = $mbox['fields'];//Meta data for field groups
		//logit($mbox_fields,'$mbox_fields');


		$args = array('post_type'=>'team');//WP Query Args

		$cals_teams_query = new WP_Query($args);//Instantiate New WP Query Object
		//logit($cals_teams_query,'$cals_teams_query');
		//logit($cals_teams_query->post->ID,'$cals_teams_query id: ');

		 ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

			$id = get_the_id();

			//logit($id,'$id: ');
			//logit(get_post_meta($id),'gpmid: ');

				$name_prefix = get_post_meta($id, 'calsteams_name_prefix')[0];
				$first_name = get_post_meta($id, 'calsteams_first_name')[0];
				$last_name = get_post_meta($id, 'calsteams_last_name')[0];
				$pro_title = get_post_meta($id, 'calsteams_professional_title')[0];

			?>

				<div>
					<a href="<?php esc_url(the_permalink()) ?>"><?php echo $name_prefix . ' ' . $first_name . ' ' . $last_name;  ?></a>

					<div><?php 
					foreach ($mbox_fields as $key => $value) {
						$field_id = $value['id'];//field id name
						$allowed_fields = array('calsteams_professional_title');

						if(get_post_meta($id,$field_id)[0] && in_array($field_id,$allowed_fields) ){

							echo $value['name'] . ': ' . get_post_meta($id,$field_id)[0] . '<br>';
							//echo $value['name'] . '<br>';
							
						}
						
						
					}

					 ?></div>

				</div>

				<?php

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
