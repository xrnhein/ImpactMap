<?php
	require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();

	$centers = json_decode($_POST['data']);

	foreach($centers as $cid) {
		if (!$map->center_referred_to($cid))
			$map->remove_center($cid);
	}
?>