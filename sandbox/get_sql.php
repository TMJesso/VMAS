<?php
require_once '/wamp/www/vmas/includes/path.php';
$sql = "SELECT * FROM user where id = 1";
$results = $db->query($sql);
$fields = $db->fetch_fields($results);
//$fields = $obj->fetch_field();
//var_dump($fields);
$db_fields;
foreach ($fields as $field) {
	
	//echo $field . "<br/>";
	//echo $value . "<br/>";
	$db_fields[] = $field->name;
}

var_dump($db_fields);



?>