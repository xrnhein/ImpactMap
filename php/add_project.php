<?php

require_once "common/dbConnect.php";
require_once "common/class.map.php";

$map = new Map();

if (isset($_POST['address'], $_POST['description'], $_POST['title'], $_POST['lat'], $_POST['lng'], $_POST['category'])) {
    if ($map -> add_project())
        echo "Database updated.";
}

?>