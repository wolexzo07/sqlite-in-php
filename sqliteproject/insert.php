<button style="margin-bottom:20pt;padding:20px;" onclick="parent.location='fetch.php'">check new data</button>
<form method="POST" onsubmit="" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

<p>Enter First Name : </p>
<div class="inp">
<input type="text" class="txt" name="fname"/>
</div>

<p>Enter Last Name : </p>
<div class="inp">
<input type="text" class="txt" name="lname"/>
</div>

<p>Enter Username : </p>
<div class="inp">
<input type="text" readonly value="<?php echo 'Tim-'.uniqid();?>" class="txt" name="uname"/>
</div>

<p>Upload Photo : </p>
<div class="inp">
<input type="file"  class="txt" name="userphoto"/>
</div>

<p>Age </p>
<div class="inp">
<input type="number" min="10" max="120" value="10" class="txt" name="age"/>
</div>

<div class="inp">
<input type="submit" value="submit data"  class="sub" name="process"/>
</div>

</form>

<?php
if(isset($_POST["age"])){
	include_once("finishit.php");
	$fname = xp("fname");$lname = xp("lname");$uname = xp("uname");
	$age = xp("age");$time = x_curtime(0,1); $os = xos();$ip = xip();
	
	xcsize("userphoto",5242880);  // 5mb allowed
	
	xcload("userphoto");

	xtex("png,gif,jpg,jpeg","userphoto");
 
	$token = sha1(uniqid().xrands(10).Date("His"))."_";
	
	$path_one = xpath("userphoto","avatar/$token");
	
	
	class MyDB extends SQlite3{
		function __construct(){
		$this->open("projectbaseplus.db");
		}
}

$db = new MyDB();


$select = "SELECT COUNT(*) AS getnum FROM userdatabase WHERE username='$uname' LIMIT 1";
$read = $db->query($select);

$result = $read->fetchArray(SQLITE3_ASSOC);

$numcount = $result["getnum"];

if($numcount > 0){
	
	print "Username <b>$uname</b> already exist!";
	
}else{
	
	// insert statement started
xmload("userphoto",$path_one,"");
$insert = "INSERT INTO userdatabase (photo_path,first_name,last_name,username,age,os,ip,dated,updated_on) VALUES ('$path_one','$fname','$lname','$uname','$age','$os','$ip','$time','')";
//$db->exec($insert);

if($db->exec($insert)){
	print "Data inserted successfully";
}else{
	print"Failed to insert data";
}

// insert statement ended
	
}


}
?>




