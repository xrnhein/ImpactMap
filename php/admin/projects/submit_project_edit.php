<?php
	/**
	* Called when the user submits the information entered into the edit project dialog. Information is sent over via POST, as is the id of the project being edited.
	* If pid = -1 that indicates that a project is being added rather than edited.
	*/

	require_once "../../common/dbConnect.php";
	require_once "../../common/class.map.php";

	$map = new Map();
	if (isset($_POST['pid'], $_POST['cid'], $_POST['title'], $_POST['status'], $_POST['startDate'], $_POST['endDate'], $_POST['buildingName'], $_POST['address'], $_POST['zip'], $_POST['type'], $_POST['summary'], $_POST['link'], $_POST['pic'], $_POST['conid'], $_POST['fundedBy'], $_POST['keyWords'], $_POST['stemmedSearchText'], $_POST['visible'], $_POST['lat'], $_POST['lng'])) {
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