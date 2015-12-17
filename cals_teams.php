<?php
/*
   Plugin Name: cals_teams
   Plugin URI: http://wordpress.org/extend/plugins/cals_teams/
   Version: 0.1
   Author: Daniel Dropik & Al Nemec
   Description: Define Custom templates in theme by creating folder cals_teams_templates/single.php 
   Text Domain: cals_teams
   License: GPLv3
  */
 //The one in cals.main verison
 
//Prevent Direct Access to this plugin
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



//Define Constants
if(!defined('CT_PLUGIN_BASE_FILE')){
  define('CT_PLUGIN_BASE_FILE',__FILE__);
}

if(!defined('CT_PLUGIN_BASE_DIR')){
  define('CT_PLUGIN_BASE_DIR',dirname(CT_PLUGIN_BASE_FILE));
}

if(!defined('CT_PLUGIN_URL')){
  define('CT_PLUGIN_URL', plugin_dir_url(__FILE__));
}

//Variables
$prefix = 'calsteams_';// 

//Functions
function create_cals_teams_post_type() {

  register_post_type( 'cals_team_members',
    array(
      'labels' => array(
        'name' => __( 'Team Members','cals_teams' ),
        'singular_name' => __( 'Team Member','cals_teams' )
        ),
      'public' => true,
      'has_archive' => true,
      'taxonomies'=>array('cals_groups'),
      'supports' => array(
        'title',
        'editor',
        'excerpt',
        'revisions',
        'thumbnail',
        'author',
        'page-attributes',
        ),
      'add_meta_box_cb'=>'add_cals_teams_metaboxes'
      )
    );
}
add_action( 'init', 'create_cals_teams_post_type' );



function create_cals_teams_taxonomies(){

  register_taxonomy('cals_groups','cals_team_members',

    array(
      'labels'=>array(
        'name'=>__('Groups','cals_teams'),
        'singular-name'=>__('Group','cals_teams'),
        ),
      'public'=>'true',
      'heirarchical'=>'true',
      'show_ui'=>'true',
      'show_in_admin_bar'=>'true',
      'show_in_nav_menus'=>'true'
      )

    );

  register_taxonomy_for_object_type( 'cals_groups', 'cals_team_members' );

}
add_action( 'init', 'create_cals_teams_taxonomies');

//fields. Prefixed by "field_"
$field_office_location = array(
	'name'=>'Offie Location',
	'desc'=>'',
	'id'=>$prefix . 'office_location',
	'type'=>'text',
	'std'=>'office location',//default value
	);

//metabox
$mbox = array(
  'id'=>'cals_teams_mbox_0',//HTML ID
  'title'=>'Team Member Data',//MetaBox Title
  'screen'=>'cals_team_members',//custom post type slug
  'context'=>'side',//display location
  'priority'=>'default',
  'fields'=>array($field_office_location),
  );

logit($mbox,'$mbox: ');

//add meta boxes
function add_meta_boxes_cals_team_members($post){

  //add_meta_box('cals_teams_cmb_OL', __('Office Location','cals_teams'), 'OL_cb','cals_team_members','side');
  
  add_meta_box($mbox['id'],$mbox['title'],'calsteams_cb',$mbox['screen'],$mb['context'],$mb['priority']);
}
add_action( 'add_meta_boxes', 'add_meta_boxes_cals_team_members' );


//callback generates form markup
function calsteams_cb($post){

  $OL_stored_meta = get_post_custom($post->ID); //get post ID
  //logit($OL_stored_meta,'$OL_stored_meta: ');
  
  $text = isset( $OL_stored_meta['mb_OL_input'] ) ? esc_attr($OL_stored_meta['mb_OL_input'][0] ) : "";

  wp_nonce_field( 'cals_teams_update_OL', 'OL_nonce');

  ?>
  <p>
    <label><?php _e('Office Locale','cals_teams') ?></label>
    <input type="text" id="mb_OL_input" name="office_location" value="<?php echo $text; ?>"/>
  </p>
  <?php
}





?>