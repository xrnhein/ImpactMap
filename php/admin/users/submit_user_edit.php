<?php
	/**
	* Submit changes to a user's properties to the database. User attributes are sent over via POST
	*/

	require_once "../../common/dbConnect.php";
	require_once "../../common/class.map.php";

	$map = new Map();

	if (isset($_POST['uid'], $_POST['cas'], $_POST['admin'])) {
		if (intval($_POST['uid']) == -1) {
			$map -> add_user();
			echo "Databse updated";
		} else {
		    $map -> update_user();
		    echo "Databse updated";
		}
	}
?>