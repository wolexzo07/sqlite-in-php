<?php
//error_reporting(0);
//@ob_start();
require "mailer/PHPMailer/src/Exception.php";
require "mailer/PHPMailer/src/PHPMailer.php";
require "mailer/PHPMailer/src/SMTP.php";

function x_print($val){
	
	if(isset($val) && !empty($val)){
		echo $val;
	}else{
		echo "Missing result!";
	}
	
}

function x_cstring(){
include("connections/baseconnect.php");
$con = mysqli_connect($host , $user , $pass , $db) or die("Error connecting: ".mysqli_error());
return $con;
}
//Send mail locally from the system
function sendmail($to,$subject,$message){
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $body             = $message;
  $mail->IsSMTP();
  $mail->SMTPAuth   = true;
  $mail->Host       = "projectbase.ng";
  $mail->Port       = 587;
  $mail->Username   = "hello@projectbase.ng";
  $mail->Password   = "Affinity1990?";
  $mail->SMTPSecure = 'tls';
  $mail->SetFrom("hello@projectbase.ng", "projectbase");
  $mail->AddReplyTo("support@projectbase.ng","projectbase");
  $mail->Subject    = $subject;
  $mail->AltBody    = "";
  $mail->MsgHTML($body);
  $address = $to;
  #$mail->AddAddress($address, $name);
  $mail->AddAddress($address, "");
  if(!$mail->Send()) {
	  return 0;
  } else {
		return 1;
 }
    }

//send remote message with phpmailer

function sendmail_local($to,$subject,$message){
$body = $message;
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSendmail();
$mail->setFrom('hello@projectbase.ng', 'Projectbase');
$mail->addReplyTo('support@projectbase.ng', 'Projectbase');
$mail->addAddress($to, '');
$mail->Subject = $subject;
#$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->MsgHTML($body);
$mail->AltBody = '';
#$mail->addAttachment('');
if (!$mail->send()){
   return 0;
}else{
    return 1;
}
    }
	
	
function x_short($str){
$str = @trim($str);
$arr = explode(" ",$str);
foreach($arr as $key){
	
	echo substr(strtoupper($key),0,1);
	
}
}

function x_random($length=32)
{
    $final_rand='';
    for($i=0;$i< $length;$i++)
    {
        $final_rand .= rand(0,9);
 
    }
 
    return $final_rand;
}

function x_cape($chk){
	return mysqli_real_escape_string(x_cstring(),$chk);
}

function xclean($chk){
	$chk = @trim($chk);
	if(!isset($chk) || empty($chk)){
		x_print("Missing compulsory fields!");
		exit();
	}else{
x_cstring();
$chk = @trim($chk);
$chk = htmlspecialchars($chk);
if(get_magic_quotes_gpc()){
$chk = stripslashes($chk);
}
return x_cape($chk);
	}

}
function xsanit($chk){
x_cstring();
$chk = @trim($chk);
$chk = htmlspecialchars($chk);
if(get_magic_quotes_gpc()){
$chk = stripslashes($chk);
}
return x_cape($chk);	
}

function xpp($chk){
	return xsanit($_POST[$chk]);
}
function xp($chk){
	return xclean($_POST[$chk]);
}

function xg($chk){
	return xclean($_GET[$chk]);
}

function xpmail($chk){
$par = "/^[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z_+])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/";
$email = $_POST[$chk];
$r = preg_match($par,$email);
if(!$r){
	x_print("Invalid email supplied");
	exit();
	}
return xclean($email);
}

function xgmail($chk){
$par = "/^[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z_+])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/";
$email = $_GET[$chk];
$r = preg_match($par,$email);
if(!$r){
	x_print("Invalid email supplied");
	exit();
	}
return xclean($email);
}

function x_clean($chk){
	
				x_cstring();
				$chk = @trim($chk);
				if(get_magic_quotes_gpc()){
				$chk = stripslashes($chk);
				}
return x_cape($chk);
				}
				
function x_connect($chk){
$read = mysqli_query(x_cstring(),$chk);				
return $read;
}


function x_counted($chk){
	$count = mysqli_num_rows(x_connect($chk));
	return $count;
}

function x_count($table,$where){
	
	if($where == "0"){
		$sele ="SELECT COUNT(*) as obey FROM $table";
	}elseif($where == "01"){
		$sele ="SELECT COUNT(*) as obey FROM $table LIMIT 1";
		}else{
		$sele ="SELECT COUNT(*) as obey FROM $table WHERE $where";
	}

if(!$read = x_connect($sele)){
$msg = "Failed to query db";
return $msg;
}else{
$assoc = mysqli_fetch_assoc($read);
$num = $assoc["obey"];
return $num;
}
}

function x_dcount($what,$table,$where){
	
	if($where == "0"){
		$sele ="SELECT COUNT(DISTINCT $what) as obey FROM $table";
	}elseif($where == "01"){
		$sele ="SELECT COUNT(DISTINCT $what) as obey FROM $table LIMIT 1";
		}else{
		$sele ="SELECT COUNT(DISTINCT $what) as obey FROM $table WHERE $where";
	}

if(!$read = x_connect($sele)){
$msg = "Failed to query db";
return $msg;
}else{
$assoc = mysqli_fetch_assoc($read);
$num = $assoc["obey"];
return $num;
}
}

function x_sum($what,$table,$where){
	
	$limit = x_count($table,$where);
	
	if(($where == "0")){
		$sele ="SELECT SUM($what) as obey FROM $table LIMIT $limit";
	}else{
		$sele ="SELECT SUM($what) as obey FROM $table WHERE $where LIMIT $limit";
	}

if(!$read = x_connect($sele)){
$msg = "Failed to query db";
return $msg;
}else{
$assoc = mysqli_fetch_assoc($read);
$num = $assoc["obey"];
return $num;
}
}

function x_query($what,$table,$where,$limit_opt,$order){
$limit = x_count($table,$where);
	if($order == "0"){
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT * FROM $table LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT $what FROM $table LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table WHERE $where LIMIT $limit";
	}else{
		$sele ="SELECT $what FROM $table WHERE $where LIMIT $limit";
	}
	}else{
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT * FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table  WHERE $where ORDER BY $order LIMIT $limit";
	}else{
		$sele ="SELECT $what FROM $table WHERE $where ORDER BY $order LIMIT $limit";
	}
	}
	return $sele;
	}


function x_select($what,$table,$where,$limit_opt,$order){
	if($limit_opt == "0"){
		$limit = x_count($table,$where);
	}else{
		$limit = $limit_opt;
	}
	
	if($order == "0"){
		
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT * FROM $table LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT $what FROM $table LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table WHERE $where LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt != "0")){
		$sele ="SELECT * FROM $table LIMIT $limit";
	}elseif(($what == "0")){
		$sele ="SELECT * FROM $table WHERE $where LIMIT $limit";
		}else{
		$sele ="SELECT $what FROM $table WHERE $where LIMIT $limit";
	}
	
	}else{
		
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT * FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table  WHERE $where ORDER BY $order LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt == "0")){
		$sele ="SELECT * FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt != "0")){
		$sele ="SELECT * FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what == "0")){
		$sele ="SELECT * FROM $table WHERE $where ORDER BY $order LIMIT $limit";
		}else{
		$sele ="SELECT $what FROM $table WHERE $where ORDER BY $order LIMIT $limit";
	}
	
	}

	
	if(!$read = x_connect($sele)){
	$msg = "Failed to select data!";
	x_print($msg);
	}else{
	while($assoc = mysqli_fetch_array($read)){
		
		$acc[] = $assoc;
	}
	return $acc;
	}
}


function x_distinct($what,$table,$where,$limit_opt,$order){
	if($limit_opt == "0"){
		$limit = x_dcount($what,$table,$where);
	}else{
		$limit = $limit_opt;
	}
	
	if($order == "0"){
		
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT DISTINCT $what FROM $table LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT DISTINCT $what FROM $table LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT DISTINCT $what FROM $table WHERE $where LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt == "0")){
		$sele ="SELECT DISTINCT $what FROM $table LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt != "0")){
		$sele ="SELECT DISTINCT $what FROM $table LIMIT $limit";
	}elseif(($what == "0")){
		$sele ="SELECT DISTINCT $what FROM $table WHERE $where LIMIT $limit";
		}else{
		$sele ="SELECT DISTINCT $what FROM $table WHERE $where LIMIT $limit";
	}
	
	}else{
		
	if(($what == "0") && ($where == "0")){
		$sele ="SELECT DISTINCT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what !== "0") && ($where == "")){
		$sele ="SELECT DISTINCT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what == "0") && ($where !== "0") && ($limit_opt == "0")){
		$sele ="SELECT DISTINCT $what FROM $table  WHERE $where ORDER BY $order LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt == "0")){
		$sele ="SELECT DISTINCT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($where == "0") && ($limit_opt != "0")){
		$sele ="SELECT DISTINCT $what FROM $table ORDER BY $order LIMIT $limit";
	}elseif(($what == "0")){
		$sele ="SELECT DISTINCT $what FROM $table WHERE $where ORDER BY $order LIMIT $limit";
		}else{
		$sele ="SELECT DISTINCT $what FROM $table WHERE $where ORDER BY $order LIMIT $limit";
	}
	
	}

	
	if(!$read = x_connect($sele)){
	$msg = "Failed to select data!";
	x_print($msg);
	}else{
	while($assoc = mysqli_fetch_array($read)){
		
		$acc[] = $assoc;
	}
	return $acc;
	}
}



function x_insert($field,$table,$values,$success,$error){
	$insert = "INSERT INTO $table ($field) VALUES($values)";
	if($read = x_connect($insert)){
			if($success == "0"){
			#$msg = "<script>alert('Data submitted successfully!')</script>";
			$msg = "";
			}else{
			$msg = $success;
			}
			x_print($msg);
	}else{
			if($error == "0"){
			$msg = "<script>alert('Data Failed to be inserted into the database!')</script>";
			}else{
			$msg = $error;
			}
			x_print($msg);
	}
}

function x_update($table,$where,$fieldval,$success,$error){
	$limit = x_count($table,$where);
	if($where == "0"){
	$update = "UPDATE $table SET $fieldval LIMIT $limit";
	}else{
	$update = "UPDATE $table SET $fieldval WHERE $where LIMIT $limit";
	}
	if($read = x_connect($update)){
			if($success == "0"){
			$msg = "<script type='text/javascript'>alert('Data updated successfully!')</script>";
			}else{
			$msg = "<script type='text/javascript'>alert('$success')</script>";
			}
			#echo $msg;
	}else{
			if($error == "0"){
			$msg = "<script type='text/javascript'>alert('Data failed to update!')</script>";
			}else{
			$msg = "<script type='text/javascript'>alert('$error')</script>";
			}
			#echo $msg;
	}
}
function x_open($colsarr,$w,$cs,$cp,$cb,$align){
#echo "<table class='table table-striped table-hover' cellspacing='$cs' width='$w' cellpadding='$cp' border='$cb'><tr>";
echo "<table id='tableID' class='table table-hover' cellspacing='$cs' width='$w' cellpadding='$cp' style='font-size:10pt;'><tr>";
$arr = explode(",",$colsarr);
	$ct =count($arr);
	foreach($arr as $key){
		$see = $key;
		if($align == "0"){
			x_print("<th>$see</th>");
		}else{
			x_print("<th align='$align'>$see</th>");	
		}

	}
	x_print("</tr>");
	}
function x_content($colsarr){
		x_print("<tr>");
$arr = explode(",",$colsarr);
	$ct =count($arr);
	foreach($arr as $key){
		$see = $key;
	x_print("<td>$see</td>");
	}
	x_print("</tr>");
}

function x_cont($colsarr){
		x_print("<tr>");
$arr = explode("~",$colsarr);
	$ct =count($arr);
	foreach($arr as $key){
		$see = $key;
	x_print("<td>$see</td>");
	}
	x_print("</tr>");
}

function x_close(){
	x_print("</table>");
}

function x_del($table,$where,$success,$error){
	$limit = x_count($table,$where);
	if($where == "0"){
	$update = "DELETE FROM $table LIMIT $limit";
	}else{
	$update = "DELETE FROM $table WHERE $where LIMIT $limit ";
	}
	if($read = x_connect($update)){
			if($success == "0"){
			$msg = "Data deleted successfully!";
			}else{
			$msg = $success;
			}
			x_print($msg);
	}else{
			if($error == "0"){
			$msg = "Data failed to delete!";
			}else{
			$msg = $error;
			}
			x_print($msg);
	}
}

#creating table
function x_create($table,$content){
	$create = "CREATE TABLE IF NOT EXISTS $table(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	$content
	)ENGINE=innodb";
	$read = x_connect($create);
	return $read;
}
#creating table with engine
function x_dbtab($table,$content,$engine){
	$create = "CREATE TABLE IF NOT EXISTS $table(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	$content
	)ENGINE=$engine";
	$read = x_connect($create);
	return $read;
}
#create database x_db($dbname)
function x_db($db){
	$create = "CREATE DATABASE IF NOT EXISTS $db";
	$read = x_connect($create);
	return $read;
}

#drop database
function x_dropdb($db){
	$create = "DROP DATABASE IF EXISTS $db";
	$read = x_connect($create);
	return $read;
}

function x_droptab($db){
	$create = "DROP TABLE IF EXISTS $db";
	$read = x_connect($create);
	return $read;
}


function x_curtime($zone,$format){
	if($format == "0"){
if($zone == "0"){
$datetime = new DateTime('now',new DateTimeZone("Africa/Lagos"));
#$dat = $datetime->format("Y-m-d H:i:s"); 
$dat = DATE("Y-m-d H:i:s"); 
return $dat;
	}else{
$datetime = new DateTime('now',new DateTimeZone("$zone"));
#$dat = $datetime->format("Y-m-d H:i:s"); 
$dat = DATE("Y-m-d H:i:s"); 
return $dat;
	}
	}else{
		if($zone == "0"){
		$datetime = new DateTime('now',new DateTimeZone("Africa/Lagos"));
$dat = $datetime->format("Y-m-d h:i:s a"); 
return $dat;
	}else{
		$datetime = new DateTime('now',new DateTimeZone("$zone"));
$dat = $datetime->format("Y-m-d h:i:s a"); 
return $dat;
	}
	}

}
function x_money($vals,$dec){
	if($dec == ""){
			$nn = number_format($vals,2);
			return $nn;
	}else{
			$nn = number_format($vals,$dec);
			return $nn;
	}

}

function finish($loc,$message){
	if($message == "0"){
		?>
		<script type="text/javascript">
		window.location="<?php x_print($loc);?>";
		</script>
	<?php
	exit();
	}elseif($loc == "0"){
				?>
		<script type="text/javascript">
		alert("<?php x_print($message);?>");
		</script>
	<?php
	}else{
		?>
		<script type="text/javascript">
		alert("<?php x_print($message);?>");
		window.location="<?php x_print($loc);?>";
		</script>
	<?php
	exit();
	}
	
}
#file upload handling functions

function x_getsize($size){
		
		$calc_kb = $size/(1024); // convert to kb
		$calc_mb = $size/(1024*1024); // convert to mb
		$calc_gb = $size/(1024*1024*1024); // convert to gb
		$calc_tr = $size/(1024*1024*1024*1024); // convert to tera
		
		if($calc_kb >= 1024){
			return number_format($calc_mb,2)."mb";
		}elseif($calc_mb >= 1024){
			return number_format($calc_gb,2)."gb";
		}elseif($calc_gb >= 1024){
			return number_format($calc_tr,2)."tb";
		}elseif($size >= 1024){
			return number_format($calc_kb,2)."kb";
		}else{
			return number_format($size,2)."b";
		}
		
		}

#get filesize
function x_size($val){
	if($val == ""){
		x_print("File variable missing!");
		exit();
	}else{
		$size = $_FILES[$val]['size']; // converting bytes
		#x_getsize($size);
	
		$calc_kb = $size/(1024); // convert to kb
		$calc_mb = $size/(1024*1024); // convert to mb
		$calc_gb = $size/(1024*1024*1024); // convert to gb
		$calc_tr = $size/(1024*1024*1024*1024); // convert to tera
		
		if($calc_kb >= 1024){
			return number_format($calc_mb,2)."mb";
		}elseif($calc_mb >= 1024){
			return number_format($calc_gb,2)."gb";
		}elseif($calc_gb >= 1024){
			return number_format($calc_tr,2)."tb";
		}elseif($size >= 1024){
			return number_format($calc_kb,2)."kb";
		}else{
			return number_format($size,2)."b";
		}
		
		
	}
}

#get extension alone
function x_file($variable){
	if(($variable == "")){
		x_print("Variable not available!");
		exit();
	}else{
		$vr = explode(".",$_FILES[$variable]['name']);
			$ext = end($vr);
		return $ext;	
	}

}


# xtex($allowed_ext,$variable) will check file extension
function xtex($allowed_ext,$variable){
	if(($allowed_ext == "") || ($variable == "")){
		x_print("File extension missing or variable not available!");
		exit();
	}else{
	#$pray = array($allowed_ext);
	$pray = explode(",",$allowed_ext);
	$vao = explode(".",$_FILES[$variable]['name']);
	$ext = strtolower(end($vao));
if(!in_array($ext,$pray)){
$msg = "format not supported($allowed_ext) ";
	x_print($msg);
	exit();
}else{
	
}
	}
	
}
# xcload($val) will check file upload status
function xcload($val){
	if($val == ""){
		x_print("File variable not available!");
		exit();
	}else{
	if(!is_uploaded_file($_FILES[$val]['tmp_name'])){
		x_print("No file is uploaded for <b>$val</b>!");
		exit();
	}else{
		}}
}
#xexit($val,$loc) will check for file existence at specified location
function xexit($val,$loc){
	if(($val == "") || (($loc == ""))){
		x_print("File target location or variable cannot be empty!");
		exit();
	}else{
		$locc = $loc.$_FILES[$val]['name'];
		if(file_exists($locc)){
		x_print("File already exist at the targeted location!");
		exit();
		}else{
				
			}
	}
	
}
#xmload($val,$loc,$file_exists) will move uploaded file to specified location
function xmload($val,$loc,$file_exists){
	if(($val == "") || (($loc == ""))){
		x_print("File target location or variable cannot be empty!");
		exit();
	}else{
		$vb = $_FILES[$val]['tmp_name'];
		$locc = $loc.$_FILES[$val]['name'];
		if($file_exists == "1"){
		if(file_exists($locc)){
		x_print("File already exist at the targeted location!");
		exit();
		}else{
				
			}
		}else{
		return move_uploaded_file($vb,$loc);
		}
	}
}

function xpath($val,$loc){
	return $loc.$_FILES[$val]['name'];
}

#xcsize($val,$maxsize) will check file size
function xcsize($val,$maxsize){
	if(($val == "") || ($maxsize == "")){
		x_print("Specify file variable or max upload size");
		exit();
	}elseif(!is_numeric($maxsize)){
		x_print("Max upload size must be numeric!");
		exit();
	}else{
		$calc = $maxsize;  //converting to byte
		$size = $_FILES[$val]['size'];
		if($size > $calc){
			$er = x_getsize($calc);
		x_print("File upload can not exceed the <b>$er</b> specified for $val");
			exit();
		}else{		
		}
	}	
}

#xrand($len) to generate random figure like;
function x_rand_tim($min,$max){
$range = $max - $min;
if($range < 1)
return $min;
$log = ceil(log($range,2));
$bytes = (int)($log/8)+1;
$bits = (int)$log + 1;
$filter = (int)(1 << $bits) - 1;
do{
$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
$rnd = $rnd & $filter;
}while ($rnd > $range);
return $min + $rnd;
}
function xrands($len){
$token = "";
$cac = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ca = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ca .= strtolower($cac);
$ca .= "0123456789";
$max = strlen($ca);
for($i=0;$i<$len;$i++){
$token .= $ca[x_rand_tim(0,$max-1)];
}
return $token;
}

#for php 7 support only
function xtoken($len){
$token = "";
$cac = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ca = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$ca .= strtolower($cac);
$ca .= "0123456789";
$max = strlen($ca);
for($i=0;$i<$len;$i++){
$token .= $ca[random_int(0,$max-1)];
}
return $token;
}

##capture device information

function xip()
{
if (!empty($_SERVER['HTTP_CLIENT_IP']))

{
$ipadd=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))

{
$ipadd=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
$ipadd=$_SERVER['REMOTE_ADDR'];
}


if($ipadd == "::1"){
	$ip = "127.0.0.1";
	return $ip;
}else{
return $ipadd;
}

}


function xbr() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}


$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function xos() { 

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
            '/windows nt 10.0/i'     =>  'Windows 10',
			'/windows nt 8.1/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

#session definations
#xstart($pick) with option 1 or 0 to start or close session
function xstart($pick){
	if($pick == 1){
			return session_write_close();
		}elseif($pick == 0){
			if(session_status() != PHP_SESSION_ACTIVE){
				//session_status() == PHP_SESSION_NONE
				//session_id() == ""
				//isset($_SESSION)
				return session_start();
				}else{
					
					}
			
			}
	}
	

	#include and require
	function xreq($val){
		if(empty($val)){
			x_print("File name cannot be empty!");
		exit();
			}else{
				return require_once($val);
			}
	
		}
		
		function xinc($val){
		if(empty($val)){
			x_print("File name cannot be empty!");
		exit();
			}else{
				return include_once($val);
			}
	
		}
		
		function xtitle($val){
			if(empty($val)){
			x_print("Page Title not specified!");
			exit();
			}else{
				x_print("<title>$val</title>");
			}
			}
			
function x_trunc($str,$start,$stop){
$len = strlen($str);
if(!is_numeric($start) || !is_numeric($stop)){
return "Error:inproper usage of x_trunc(str,start,stop)";
}else{

if($len > $start){
return substr($str,$start,$stop)."......";
}elseif($len < $start){
return substr($str,$start,$stop);
}else{
return $start;
}
}
}

function x_vert($str,$wrap){
	if($wrap == ""){
		return ucwords(strtolower($str));
	}else{
return "<$wrap>".ucwords(strtolower($str))."</$wrap>";		
		}
}
function xlow($str,$wrap){
		if($wrap == ""){
		return strtolower($str);
	}else{
return "<$wrap>".strtolower($str)."</$wrap>";		
		}
	
}
function xup($str,$wrap){
	if($wrap == ""){
		return strtoupper($str);
	}else{
return "<$wrap>".strtoupper($str)."</$wrap>";		
		}
}

//curl functions usage
/**
		$params = array(
			   "api_key" => $api,
			   "recipient" => $result,
			   "message" => $msg,
				"sender" => $sender,
				 "route" => $route
				);
**/
function xget($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
}

function xpost($url,$params)
{
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
 
}

//curl in json response
function x_google($url,$params)
{
	
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
      
   }
   $postData = rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    
    return json_decode($output,true);
 
}

function x_datediff($date1,$date2){
	if(($date1 == "") || ($date2 == "")){
	
		x_print("Empty date variable");
		
		}else{
			
			$data1 = new DateTime($date1);
			$data2 = new DateTime($date2);
			
			$diff = $data1->diff($data2);
			return $diff->y.'years ,'.$diff->m.'months ,'.$diff->d.'days ,';
			
			}
	
	}
	
function x_multiple_upload($file_name,$folder_name,$success,$failed){
if(isset($file_name) && !empty($file_name) && isset($folder_name) && !empty($folder_name)  && isset($success) && !empty($success) && isset($failed) && !empty($failed)){
	
	if(isset($_FILES[$file_name])){
    $name_array = $_FILES[$file_name]['name'];
    $tmp_name_array = $_FILES[$file_name]['tmp_name'];
    $type_array = $_FILES[$file_name]['type'];
    $size_array = $_FILES[$file_name]['size'];
    $error_array = $_FILES[$file_name]['error'];
    for($i = 0; $i < count($tmp_name_array); $i++){
		$ipbase = ($i+13) + rand(452,9183782321);
		$hash = sha1($ipbase)."_".sha1(crypt($ipbase));
  if(move_uploaded_file($tmp_name_array[$i], $folder_name.$hash.$name_array[$i])){
				  
				  if($success == "y"){
					  
				  x_print("<b>".$name_array[$i]."</b>"." upload is complete<br>");
				  
				  }else{
				  
				  }
            
        } else {
			 if($failed == "y"){
				x_print("Upload failed for ".$name_array[$i]."<br>");
					}else{
				  
				  }
			
        }
    }
}else{
	x_print("Major Parameter Missing!");
}
	
}else{
	x_print("Upload Parameter Missing!");
}


}

function x_wordfilter($data,$originals,$replacements){
	
	if(empty($originals) || empty($replacements)){
		x_print("Array parameters is empty");
	}elseif(!is_array($originals) || !is_array($replacements)){
		x_print("Parameters must be an array");
	}else{
    $data = str_ireplace($originals,$replacements,$data);
    return $data;
	}
 
}



?>
