<?php
	require_once "common/dbConnect.php";
    require_once "common/class.map.php";

    $map = new Map();

	$projects = json_decode($_POST['data']);

	foreach($projects as $project) {
		$map->remove($project);
	}
?>