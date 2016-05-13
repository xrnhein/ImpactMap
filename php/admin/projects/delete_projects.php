<?php
	/**
	* Called when a user wants to delete projects from the table. The project IDs are sent over as a json encoded array
	*/

	require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();

	$projects = json_decode($_POST['data']);

	foreach($projects as $project) {
		$map->remove_project($project);
	}
?>