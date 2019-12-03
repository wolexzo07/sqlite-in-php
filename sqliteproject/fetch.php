<?php
include_once("finishit.php");
class MyDB extends SQlite3{
		function __construct(){
		$this->open("projectbaseplus.db");
		}
}
$db = new MyDB();
$select = "SELECT * FROM userdatabase LIMIT 200";
$read = $db->query($select);
?>
<button style="margin-bottom:20pt;padding:20px;" onclick="parent.location='insert.php'">Add new data</button>
<table width="100%" cellpadding="10px" cellspacing="0px" border="1px">
<tr align="left">
<th>No.</th>
<th>Photo</th>
<th>Fullname</th>
<th>Username</th>
<th>Age</th>
<th>Dated</th>
<th>Action</th>
</tr>
<?php
$counter = 0;
while($result = $read->fetchArray(SQLITE3_ASSOC)){
	$counter++;
	$id = $result["id"];
	$ph = $result["photo_path"];
	$name = $result["first_name"]." ".$result["last_name"];
	$user = $result["username"];
	$age = $result["age"];
	$os = $result["os"];
	$ip = $result["ip"];
	$date = $result["dated"];
	$upd = $result["updated_on"];
	
	?>
	<tr>
<td><?php x_print($counter);?></td>
<td><img src="<?php x_print($ph);?>" class="" style="width:190px;border:4px solid lightgray;"/></td>
<td><?php x_print($name);?></td>
<td><?php x_print($user);?></td>
<td><?php x_print($age);?></td>
<td><?php x_print($date);?></td>
<td>
<button class="" onclick="parent.location='delete.php?id=<?php x_print($id);?>'">Delete</button>
<button onclick="parent.location='update.php?id=<?php x_print($id);?>'">Update</button>
</td>
</tr>
	<?php
}

?></table>