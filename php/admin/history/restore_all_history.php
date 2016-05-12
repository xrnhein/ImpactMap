<?php
	require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();

	$timestamp = $_POST['data'];

	$map->restore_all_history($timestamp);
?>