<?php
    require_once "common/dbConnect.php";
    require_once "common/class.map.php";

    $map = new Map();
    $pid = 0;

    if (isset($_POST['pid'])) 
        $pid = intval($_POST['pid']);

    $filtered = $map -> load_project_details($pid);

    echo '<label for="title">Title: </label><input type="text" class="form-control" id="title" name="title" value="' . $filtered['title'] . '">';
    echo '<label for="description">Description: </label><textarea class="form-control" id="description"  name="description" rows="10">' . $filtered['description'] . '</textarea>';
    echo '<label for="address">Address: </label><input type="text" class="form-control" id="address" name="address" value="' . $filtered['address'] . '">';
    echo '<label for="lat">Latitude: </label><input type="text" class="form-control" id="lat" name="lat" value="' . $filtered['lat'] . '">';
    echo '<label for="lng">Longitude: </label><input type="text" class="form-control" id="lng" name="lng" value="' . $filtered['lng'] . '">';
    echo '<label for="category">Center: </label><input type="text" class="form-control" id="category" name="category" value="' . $filtered['category'] . '">';
    echo '<input type="submit" value="Submit" onclick="submitEditProject(' . $pid . ')"><br>';
?>


<br>
<a href="#" onclick="closePopup()">Close</a>