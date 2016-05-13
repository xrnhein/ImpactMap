<?php
	/**
	* Called to load all the projects that meet the specified filters. Results are returned as a json encoded array
	*/

	require_once "../../common/dbConnect.php";
	require_once "../../common/class.map.php";

	$map = new Map();
	$filters = array();

	if (isset($_POST['limit']))             $filters['limit'] = intval($_POST['limit']);
	if (isset($_POST['minLat']))            $filters['minLat'] = floatval($_POST['minLat']);
	if (isset($_POST['maxLat']))            $filters['maxLat'] = floatval($_POST['maxLat']);
	if (isset($_POST['minLng']))            $filters['minLng'] = floatval($_POST['minLng']);
	if (isset($_POST['maxLng']))            $filters['maxLng'] = floatval($_POST['maxLng']);
	if (isset($_POST['category']))          $filters['category'] = trim($_POST['category']);

	$filtered = $map -> load_projects($filters);

	echo json_encode($filtered);

?>