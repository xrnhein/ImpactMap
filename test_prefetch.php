<?php

require_once "php/common/dbConnect.php";
require_once "php/common/class.map.php";

$map = new Map();

$map->generate_prefetch();

?>