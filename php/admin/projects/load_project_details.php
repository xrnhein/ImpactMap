<?php

require_once "../../common/dbConnect.php";
require_once "../../common/class.map.php";

$map = new Map();
$pid = 0;

if (isset($_POST['pid'])) 
	$pid = intval($_POST['pid']);

$filtered = $map -> load_project_details($pid);

echo json_encode($filtered);

?>