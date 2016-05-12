<?php
	require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();

	$users = json_decode($_POST['data']);

	foreach($users as $uid) {
		$map->remove_user($uid);
	}
?>