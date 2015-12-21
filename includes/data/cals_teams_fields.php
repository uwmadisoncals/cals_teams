<?php 
///FIELD DEFINITIONS

//Variables
$prefix = 'calsteams_';// 

//fields. Prefixed by "field_"
$field_office_location = array(
  'name'=>'Offie Location',
  'desc'=>'This is where the office is.',
  'id'=>$prefix . 'office_location', //corresponds to input field name & id
  'type'=>'text',
  'std'=>'office location',//default value
  );

//field2
$field_office_location2 = array(
  'name'=>'Room Number',
  'desc'=>'This is where the room is.',
  'id'=>$prefix . 'room_number', //corresponds to input field name & id
  'type'=>'text',
  'std'=>'',//default value
  );


//metabox args
$mbox = array(
  'id'=>'cals_teams_mbox_0',//HTML ID
  'title'=>'Team Member Data',//MetaBox Title
  'screen'=>'team',//custom post type slug
  'context'=>'normal',//display location
  'priority'=>'default',
  'fields'=>array($field_office_location,$field_office_location2),
  );
 ?>