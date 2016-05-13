<?php

	/**
	* Called with a string of stemmed (i.e. running -> run) keywords to search for, matches are returned as a JSON array
	*/

	require_once "../common/dbConnect.php";
	require_once "../common/class.map.php";

	$map = new Map();

	if (isset($_POST['stemmedSearchText'])) {
	    $searchPhrase = trim($_POST['stemmedSearchText']);
	    $results = $map -> search($searchPhrase);
	    echo json_encode($results);
	}

?>