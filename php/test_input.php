<?php

require_once "common/dbConnect.php";
require_once "common/class.map.php";

$map = new Map();

if (isset($_POST['address'], $_POST['description'], $_POST['title'])) {
    if ($map -> create_entry())
        echo "Database updated.";
}

?>