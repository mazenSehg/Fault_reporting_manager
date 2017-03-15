<?php
// define site details
global $db;

define( 'INC_URL' , site_url() . '/' . INC );
define( 'CONTENT_URL' , site_url() . '/' . CONTENT );
define( 'CSS_URL' , site_url() . '/' . CONTENT .'/assets/css/' );
define( 'JS_URL' , site_url() . '/' . CONTENT .'/assets/js/' );
define( 'IMAGE_URL' , site_url() . '/' . CONTENT .'/assets/img/' );
define( 'PROCESS_URL' , site_url() . '/' . INC .'/process.php' );
define( 'TABLE_PROCESS_URL' , site_url() . '/' . INC .'/table-process.php' );


define( 'BLOG_NAME' ,'Fault Management' );
define( 'ADMIN_EMAIL' ,'info@prospectstrails.com' );
define( 'NO_REPLY' ,'no-reply@prospectstrails.com' );


define( 'TBL_USERS' , $db->prefix. 'users' );
define( 'TBL_USERMETA' , $db->prefix. 'usermeta' );
define( 'TBL_OPTION' , $db->prefix. 'options' );
define( 'TBL_ACCESS_LOG' , $db->prefix. 'access_log' );
define( 'TBL_NOTIFICATIONS' , $db->prefix. 'notifications' );
define( 'TBL_CENTRES' , $db->prefix. 'centres' );
define( 'TBL_FAULTS' , $db->prefix. 'fault' );
define( 'TBL_FAULT_TYPES' , $db->prefix. 'fault_type' );
define( 'TBL_EQUIPMENTS' , $db->prefix. 'equipment' );
define( 'TBL_EQUIPMENT_TYPES' , $db->prefix. 'equipment_type' );
define( 'TBL_SERVICE_AGENTS' , $db->prefix. 'service_agent' );
define( 'TBL_MANUFACTURERS' , $db->prefix. 'manufacturer' );
define( 'TBL_MODELS' , $db->prefix. 'model' );
define( 'TBL_REGIONS' , $db->prefix. 'region' );
define( 'TBL_REGION_BODY' , $db->prefix. 'region_body' );
define( 'TBL_SUPPLIERS' , $db->prefix. 'supplier' );
?>