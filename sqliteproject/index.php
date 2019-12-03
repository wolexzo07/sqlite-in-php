<?php
class MyDB extends SQlite3{
		function __construct(){
		$this->open("projectbaseplus.db");
		}
}

$db = new MyDB();
// insert statement started
$insert = "INSERT INTO userdatabase (photo_path,first_name,last_name,username,age,os,ip,dated) VALUES ('','','','','','','','')";
if($db->exec($insert)){
	print("Data inserted successfully");
}else{
	print("Failed to insert data");
}
// insert statement ended

$select = "SELECT * FROM userdatabase LIMIT 400";
$read = $db->query($select);
while($result = $read->fetchArray(SQLITE3_ASSOC)){
	$id = $result["id"];
	$ph = $result["photo_path"];
	$name = $result["first_name"]." ".$result["last_name"];
	$user = $result["username"];
	$age = $result["age"];
	$os = $result["os"];
	$ip = $result["ip"];
	$date = $result["dated"];
	$upd = $result["updated_on"];
	
	?><?php
}
?>