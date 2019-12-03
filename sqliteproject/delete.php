<?php
include_once("finishit.php");

$id = xg("id");
class MyDB extends SQlite3{
		function __construct(){
		$this->open("projectbaseplus.db");
		}
}
$db = new MyDB();
$del = "DELETE FROM userdatabase WHERE id='$id'";
if($db->exec($del)){
	finish("fetch.php","Data deleted");
}else{
	finish("fetch.php","Failed to delete");
}

?>