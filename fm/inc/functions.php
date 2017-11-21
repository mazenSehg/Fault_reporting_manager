<?php
require_once( ABSPATH . INC . '/user-functions.php');

if ( !function_exists('require_db') ) :
	function require_db() {
		global $db;
		require_once( ABSPATH . INC . '/db.php' );
		if ( isset( $db ) )
			return;
		$db = new db( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
	}
endif;

if ( !function_exists('checkSpacing') ) :
	function checkSpacing($val) {
		return $val;
	}
endif;

if ( !function_exists('site_url') ) :
	function site_url(){
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])):
			$url = 'https://';
		else:
			$url = 'http://';
		endif;
		$url .= $_SERVER['HTTP_HOST'];
		if ( defined('WEBPATH') )
			$url .= '/'.WEBPATH;
		return $url;	
	}
endif;

if( !function_exists('sanitize_user')) :
	function sanitize_user( $username, $strict = false ) {
		$raw_username = $username;
		$username = strip_all_tags( $username );
		// Kill octets
		$username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
		$username = preg_replace( '/&.+?;/', '', $username ); // Kill entities
		// If strict, reduce to ASCII for max portability.
		if ( $strict )
			$username = preg_replace( '|[^a-z0-9 _.\-@]|i', '', $username );

		$username = trim( $username );
		// Consolidate contiguous whitespace
		$username = preg_replace( '|\s+|', ' ', $username );
		return $username;
	}
endif;

if( !function_exists('strip_all_tags')) :
	function strip_all_tags($string, $remove_breaks = false) {
		$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
		$string = strip_tags($string);
		if ( $remove_breaks )
			$string = preg_replace('/[\r\n\t ]+/', ' ', $string);
		return trim( $string );
	}
endif;

if( !function_exists('absint')) :
	function absint( $maybeint ) {
		return abs( intval( $maybeint ) );
	}
endif;

if( !function_exists('_e') ):
	function _e($text){
		echo stripslashes($text);
	}
endif;

if( !function_exists('__') ):
	function __($text){
		return stripslashes($text);
	}
endif;

if(!function_exists('checked')):
	function checked($checker , $default){
		echo ($checker == $default) ? 'checked' : '';
	}
endif;

if( !function_exists('get_option')) :
	function get_option($option){
		global $db;
		$value = '';
		$row = get_tabledata(TBL_OPTION, true, array('option_name' => $option));
		if ($row) {
			$value = maybe_unserialize($row->option_value);
		}
		return $value;
	}
endif;

if( !function_exists('add_option')) :
	function add_option( $option, $value = ''){
		global $db;
		$option = trim($option);
		if ( empty($option) )
			return false;
		$serialized_value = maybe_serialize( $value );
		$result = $db->query( sprintf("INSERT INTO ".TBL_OPTION." (`option_name`, `option_value`) VALUES (%s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`)", $option, $serialized_value ) );
		if ($result ){
			return true;
		}
		return false;
	}
endif;

if( !function_exists('update_option')) :
	function update_option( $option, $value = ''){
		global $db;
		$option = trim($option);
		if ( empty($option) )
			return false;
		$old_value = get_option( $option );
		if ( $value === $old_value )
			return false;
		$serialized_value = maybe_serialize( $value );
		$update_args = array(
			'option_value' => $serialized_value,
		);
		$check = get_tabledata(TBL_OPTION, false, array( 'option_name' => $option ));
		if($check):
			$result = $db->update( TBL_OPTION, $update_args, array( 'option_name' => $option ) );
		else:
			$result = $db->insert( TBL_OPTION, array( 'option_name' => $option , 'option_value' => $serialized_value) );
		endif; 
		
		if ($result ){
			return true;
		}
		return false;
	}
endif;

if( !function_exists('delete_option')) :
	function delete_option( $option ) {
		global $db;
		$option = trim( $option );
		if ( empty( $option ) )
			return false;
		$row = $db->get_row( sprintf("SELECT ID FROM ".TBL_OPTION." WHERE option_name = %s", $option ) );
		if ( is_null( $row ) )
			return false;

		$result = $wpdb->delete( TBL_OPTION, array( 'option_name' => $option ) );
		if ($result ){
			return true;
		}
		return false;
	}
endif;

if( !function_exists('maybe_serialize')) :
	function maybe_serialize( $data ) {
		if ( is_array( $data ) || is_object( $data ) )
			return serialize( $data );
		if ( is_serialized( $data, false ) )
			return serialize( $data );

		return $data;
	}
endif;

if( !function_exists('maybe_unserialize')) :
	function maybe_unserialize( $original ) {
		if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
			return @unserialize( $original );
		return $original;
	}
endif;

if( !function_exists('is_serialized')) :
	function is_serialized( $data, $strict = true ) {
		// if it isn't a string, it isn't serialized.
		if ( ! is_string( $data ) ) {
			return false;
		}
		$data = trim( $data );
	 	if ( 'N;' == $data ) {
			return true;
		}
		if ( strlen( $data ) < 4 ) {
			return false;
		}
		if ( ':' !== $data[1] ) {
			return false;
		}
		if ( $strict ) {
			$lastc = substr( $data, -1 );
			if ( ';' !== $lastc && '}' !== $lastc ) {
				return false;
			}
		} else {
			$semicolon = strpos( $data, ';' );
			$brace     = strpos( $data, '}' );
			// Either ; or } must exist.
			if ( false === $semicolon && false === $brace )
				return false;
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 )
				return false;
			if ( false !== $brace && $brace < 4 )
				return false;
		}
		$token = $data[0];
		switch ( $token ) {
			case 's' :
				if ( $strict ) {
					if ( '"' !== substr( $data, -2, 1 ) ) {
						return false;
					}
				} elseif ( false === strpos( $data, '"' ) ) {
					return false;
				}
				// or else fall through
			case 'a' :
			case 'O' :
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
			case 'b' :
			case 'i' :
			case 'd' :
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		}
		return false;
}
endif;

if( !function_exists('get_site_name')) :
	function get_site_name(){
		$value = get_option('site_name');
		$return = ($value != '') ? $value : BLOG_NAME;
		return $return;
	}
endif;

if( !function_exists('get_site_description')) :
	function get_site_description(){
		$value = get_option('site_description');
		$return = ($value != '') ? $value : '';
		return $return;
	}
endif;

if( !function_exists('password_generator')) :
	function password_generator(){
		if( function_exists('uniqid')) :
			return md5(uniqid(rand(),true));
		else:				
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUWVXYZ01234567890!@#$%^&*~';
			$token = '';					
			for ($x = 0; $x < 8; $x++){						
				$token .= $chars[ rand(0, strlen($chars)-1) ];				
			}
			return $token;
		endif;		
	}
endif;

if( !function_exists('createThumb')) :
	//function for creating image thumbnail
	function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
		/* read the source image */
		$source_image = FALSE;
		
		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($path1);
		}
		elseif (preg_match("/png|PNG/", $file_type)) {
			
			if (!$source_image = @imagecreatefrompng($path1)) {
				$source_image = imagecreatefromjpeg($path1);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($path1);
		}		
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($path1);
		}

		$orig_w = imageSX($source_image);
		$orig_h = imageSY($source_image);
		
		if ($orig_w < $new_w && $orig_h < $new_h) {
			$desired_width = $orig_w;
			$desired_height = $orig_h;
		} else {
			$scale = min($new_w / $orig_w, $new_h / $orig_h);
			$desired_width = ceil($scale * $orig_w);
			$desired_height = ceil($scale * $orig_h);
		}
				
		if ($squareSize != '') {
			$desired_width = $desired_height = $squareSize;
		}

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		// for PNG background white----------->
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);
		
		if ($squareSize == '') {
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		} else {
			$wm = $orig_w / $squareSize;
			$hm = $orig_h / $squareSize;
			$h_height = $squareSize / 2;
			$w_height = $squareSize / 2;
			
			if ($orig_w > $orig_h) {
				$adjusted_width = $orig_w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
			}

			elseif (($orig_w <= $orig_h)) {
				$adjusted_height = $orig_h / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
			} else {
				imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
			}
		}
		
		if (@imagejpeg($virtual_image, $path2, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			return TRUE;
		} else {
			return FALSE;
		}
	}
endif;

if( !function_exists('paginate')) :
	//function for getting paginate list
	function paginate($url, $page, $tpages) {
		$adjacents = 2;
		$prevlabel = "&laquo;";
		$nextlabel = "&raquo;";
		$first = "&larr;";
		$last = "&rarr;";
		$out = "";
		// previous
		if ($page == 1) {
			$out.= "<li class=\"disabled\"  aria-label=\"Previous\"><a href='javascript:void(0);'><span aria-hidden=\"true\">". $first. "</span></a></li>\n";
			$out.= "<li class=\"disabled\"  aria-label=\"Previous\"><a href='javascript:void(0);'><span aria-hidden=\"true\">" . $prevlabel . "</span></a></li>\n";
		} elseif ($page == 2) {
			$out.= "<li><a  href=\"" . $url . "/?page=1" . "\">". $first. "</a></li>";
			$out.= "<li><a  href=\"" . $url . "/?page=" . ($page - 1) .  "\">" . $prevlabel . "</a></li>";
		} else {
			$out.= "<li><a  href=\"" . $url . "/?page=1" . "\">". $first. "</a></li>";
			$out.= "<li><a  href=\"" . $url . "/?page=" . ($page - 1) .  "\">" . $prevlabel . "</a></li>";
		}
	  
		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out.= "<li  class=\"active\"><a href='javascript:void(0);'>" . $i . "</a></li>";
			} elseif ($i == 1) {
				$out.= "<li><a  href=\"" . $url . "/?page=" . $i . "\">" . $i . "</a></li>";
			} else {
				$out.= "<li><a  href=\"" . $url . "/?page=" . $i .  "\">" . $i . "</a></li>";
			}
		}
	    
		if ($page < ($tpages - $adjacents)) {
			$out.= "<li><a href=\"" . $url . "/?page=" . $tpages .  "\">" . $tpages . "</a></li>";
		}
		// next
		if ($page < $tpages) {
			$out.= "<li><a  href=\"" . $url . "/?page=" . ($page + 1) .  "\">" . $nextlabel . "</a></li>";
			$out.= "<li><a  href=\"" . $url . "/?page=" .$tpages. "\">". $last. "</a></li>";
		} else {
			$out.= "<li class=\"disabled\" aria-label=\"Next\"><a href='javascript:void(0);' ><span aria-hidden=\"true\">" . $nextlabel . "</span></a></li>";
			$out.= "<li class=\"disabled\" aria-label=\"Next\"><a href='javascript:void(0);' ><span aria-hidden=\"true\">". $last. "</span></a></li>";
		}
		$out.= "";
		return $out;
	}
endif;


if ( !function_exists('login_check') ) :
	function login_check(){
		if(!is_user_logged_in()):
			$uri = site_url();
			header("location:".$uri);
			die();
		endif;
	}
endif;

if ( !function_exists('page_not_found') ) :
	function page_not_found($msg1='', $msg2= '',$btn_status = true){
		
		if($msg1 == ''){
			$msg1 = 'Oops ! Something Went Wrong.';
		}
		if($msg2 == ''){
			$msg2 = 'Please try again !!';
		}
		ob_start();
		?>
		<div class="row">
			<div class="col-xs-12">
				<div class="not-found-page text-center">
					<h1 class="green"><i class="fa fa-frown-o fa-5x"></i></h1>
					<h1><?php echo stripslashes($msg1);?></h1>
					<h4><?php echo stripslashes($msg2);?></h4>
					<p>&nbsp;</p>
					<?php if( $btn_status === true): ?>
					<a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="btn btn-sm btn-dark"><i class="fa fa-long-arrow-left"></i> &nbsp;Go Back </a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		$content = ob_get_clean();
		return $content;
	}
endif;

if ( !function_exists('send_email') ) :
	function send_email($from,$name,$to,$subject,$body){	
		require_once( ABSPATH . INC. '/phpmailer/PHPMailerAutoload.php');	
		$mail = new PHPMailer();
		if(SMTP_STATUS == '1'):
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = SMTP_SECURE;
			$mail->Host = SMTP_HOST;
			$mail->Port = SMTP_PORT;
			$mail->Username = SMTP_USER;
			$mail->Password = SMTP_PASS;
		endif;
		$mail->CharSet = 'UTF-8';
		$mail->SetFrom($from,$name,0);
		$mail->AddReplyTo($reply_email);
		$mail->AddAddress($to);
		
		if($attachment_files != '' || !empty($attachment_files)){
			foreach($attachment_files as $name=>$file){
				$file_to_attach = $attachment_files['tmp_name'][$name];
				$mail->AddAttachment($file_to_attach);
			}
		}
		$mail->Subject = $subject;
		$mail->Body =$body;
		$mail->isHtml(true);
		if($mail->send()){
			return true;
		}else{
			return false;
		}
	} 
endif;

if ( !function_exists('get_unread_notification_count') ) :
	function get_unread_notification_count(){
		global $db;
		$current_user_id = get_current_user_id();
		$result = get_tabledata(TBL_NOTIFICATIONS,false,array(
			'user_id' => $current_user_id,
			'hide' => 0,
			'read' => 0
		));
		return count($result);
	}
endif;

if ( !function_exists('get_device_name') ) :
	function get_device_name(){
		require_once( ABSPATH . CONTENT. '/class/class.mobile-detect.php');
		$detect = new Mobile_Detect;
		if($detect->isTablet() ){
			$device = 'Tablet';
		}else	if( $detect->isMobile() && !$detect->isTablet() ){
			$device = 'Mobile';
		}else{
			$device = 'Desktop/Laptop';
		}
		return $device;
	}
endif;

if ( !function_exists('add_user_notification') ) :
	function add_user_notification($args){
		global $db;
		if(!empty($args)){
			$current_user_id = get_current_user_id();
			$args['user_id'] = $current_user_id;
			$db->insert(TBL_NOTIFICATIONS,$args);
		}
	}
endif;

if ( !function_exists('get_replaced_string') ) :
	function get_replaced_string($short_code,$hash,$text){
		return str_replace($short_code,$hash,$text);
	}
endif;

if ( !function_exists('get_tabledata') ) :
	function get_tabledata($table,$single = true, $where = array() , $extra = '', $select = '*'){
		global $db;
		if($table == null || $table == null)
			return false;
		
		if(is_array($select)){
			$select = implode(',',$select);
		}
		
		$query = "SELECT ".$select." FROM $table ";
		
		if(!empty($where) ){
			foreach ( $where as $field => $value ) {
				if ( is_null( $value ) ) {
					$conditions[] = "`$field` IS NULL";
					continue;
				}
				$conditions[] = "`$field` = '". $value ."' ";
			}
			$conditions = implode( ' AND ', $conditions );
			$query .= " WHERE ".$conditions ." " ;
		}
		
		if($extra != '')
			$query .= $extra;
			
		if($single)
			return $db->get_row($query);
		else
			return $db->get_results($query);
	}
endif;

if ( !function_exists('get_option_data') ) :
	function get_option_data($data, $args){
		if($data == null || empty($data))
			return false;
		if($args == null || empty($args))
			return false;
		
		$return = array();
		
		foreach($data as $val){	
			$return[$val->$args[0]] = $val->$args[1];
		}	
		return $return;
	}	
endif;

if ( !function_exists('short_text') ) :
	function short_text($value = '', $len = 100){
		if($value == '' || $value == null)
			return false;
		
		$len = $len;
		
		if($len == 0)
			$len = 100;
			
		if(strlen($value) > $len){
			$value = substr($value,0,70) . '...';
		}
		
		return $value;
	}
endif;

if ( !function_exists('get_guid') ) :
	function get_guid($table_name, $length = 6){
		if($length < 2)		
			$length = 6;
					
		do{
			$pass = '';			
			$allowed_characters = array(1,2,3,4,5,6,7,8,9,0);
			for($i = 1;$i <= $length; $i++){
				$pass .= $allowed_characters[rand(0, count($allowed_characters) - 1)];
			}
			$pass = '10000' . $pass;
			if(!is_in_table($table_name,$pass))
				break;				
		}while (true);				
		return $pass;    		
	}
endif;


if ( !function_exists('update_names') ) :
	function update_names($ID){
				global $db;
		
		$string = NULL;
              $sql1 = "SELECT * FROM tbl_equipment WHERE ID = '$ID'";
							$res1 = $db->get_results($sql1);
							foreach($res1 as $a):
							
							$manufac = NULL;
							
							if($a->manufacturer!=null||$a->manufacturer=0){
							$sql2 = "SELECT * FROM tbl_manufacturer WHERE ID = $a->manufacturer";
							$res2 = $db->get_results($sql2);
							foreach($res2 as $b):
								$manufac = $b->name;
							endforeach;
							}
							
							$model = NULL;
							
							if($a->model!=null){
							$sql3 = "SELECT * FROM tbl_model WHERE ID = $a->model";
							$res3 = $db->get_results($sql3);
							foreach($res3 as $c):
								$model = $c->name;
							endforeach;
							}
							
							
	
							
							$string = null;
							if(isset($manufac)&&!isset($model)){
								$string = $manufac . " | ";
							}
							if(!isset($manufac)&&isset($model)){
								$string = $manufac . " | ";
							}
							if(isset($manufac)&&isset($model)){
								$string = $manufac . " | " . $model;
							}
							
							
							
							
							if($a->serial_number!=null){
								$serial = $a->serial_number;							
								$string = $string . " | ". $serial;

							}
							if($a->year_installed!=null){
							$year_installed = $a->year_installed;
								$string = $string . " | ". $year_installed;
							}
							if($a->location_id!=null){
								$location_id = $a->location_id;
								$string = $string . " | ". $location_id;
							}
							if($a->location!=null){
								$location = $a->location;
								$string = $string . " | ". $location;
							}

							$string = $string;
							
							endforeach;
		
		return $string;    		
	}
endif;





if ( !function_exists('is_in_table') ) :
	function is_in_table($table_name,$id){
		$data = get_tabledata($table_name, false, array('ID' => $id));
		if($data)
			return true;
			
		return false;
	}	
endif;

if(!function_exists('text_editor')):
	//function for getting text editor
	function text_editor($id,$value=''){
		ob_start();
		?>
		<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#<?php echo$id;?>-box">
			<div class="btn-group">
				<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font">
					<i class="fa fa-font"></i><b class="caret"></b>
				</a>
				<ul class="dropdown-menu"></ul>
			</div>

			<div class="btn-group">
				<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height">
					</i>&nbsp;<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a data-edit="fontSize 5">
							<p style="font-size:17px">Huge</p>
						</a>
					</li>
					<li>
						<a data-edit="fontSize 3">
							<p style="font-size:14px">Normal</p>
						</a>
					</li>
					<li>
						<a data-edit="fontSize 1">
							<p style="font-size:11px">Small</p>
						</a>
					</li>
				</ul>
			</div>

			<div class="btn-group">
				<a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
				<a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
				<a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
				<a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
			</div>

			<div class="btn-group">
				<a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
				<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
				<a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
				<a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
			</div>

			<div class="btn-group">
				<a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
				<a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
				<a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
				<a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
			</div>

			<div class="btn-group">
				<a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
				<div class="dropdown-menu input-append">
					<input class="span2" placeholder="URL" type="text" data-edit="createLink" />
					<button class="btn" type="button">Add</button>
				</div>
				<a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
			</div>

			<div class="btn-group">
				<a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
				<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
			</div>

			<div class="btn-group">
				<a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
				<a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
			</div>
		</div>

		<div id="<?php echo $id;?>-box" class="editor-box editor-wrapper" data-id="<?php echo $id;?>"><?php echo $value;?></div>

		<textarea name="<?php echo $id;?>" id="<?php echo $id;?>" style="display:none;"><?php echo $value;?></textarea>

		<br />

		<div class="ln_solid"></div>
		<?php
		$content = ob_get_clean();
		return $content;
	}
endif;

if( !function_exists('get_options_list')):
	function get_options_list($data, $value = array()){
		$selected = '';
		$return = '<option value=""></option>';
		
		if($data == null || $data == '' || !is_array($data) || empty($data))
			return $data;
		
		if(!is_array($value)){
			if($value == '' || $value == null){
				$value = array();
			}else{
				$value = (array)$value;	
			}
		}
		foreach($data as $key => $val):
			$selected = (!empty($value) && in_array($key,$value) ) ? 'selected' : '';
				$return .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
		endforeach;
		
		
		
		return $return;
	}
endif;


if( !function_exists('get_options_list2')):
	function get_options_list2($data, $value = array()){
		$selected = '';
		$return = '<option value=""></option>';
		
		if($data == null || $data == '' || !is_array($data) || empty($data))
			return $data;
		
		if(!is_array($value)){
			if($value == '' || $value == null){
				$value = array();
			}else{
				$value = (array)$value;	
			}
		}
		foreach($data as $key => $val):
			$selected = (!empty($value) && in_array($key,$value) ) ? 'selected' : '';
				$return .= '<option selected="'.$key.'" '.$selected.'>'.$val.'</option>';
		endforeach;
		
		return $return;
	}
endif;
?>
