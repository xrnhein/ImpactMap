<?php

require_once "common/dbConnect.php";
require_once "common/class.map.php";

$map = new Map();
if (isset($_POST['pid'], $_POST['cid'], $_POST['title'], $_POST['status'], $_POST['startDate'], $_POST['endDate'], $_POST['buildingName'], $_POST['address'], $_POST['zip'], $_POST['type'], $_POST['summary'], $_POST['link'], $_POST['pic'], $_POST['contactName'], $_POST['contactEmail'], $_POST['contactPhone'], $_POST['stemmedSearchText'], $_POST['lat'], $_POST['lng'])) {
	if (intval($_POST['pid']) == -1) {
		$map -> add_project();
		echo "Databse updated";
	} else {
	    $map -> update_project();
	    echo "Databse updated";
	}

	$map->generate_prefetch();
}

?>