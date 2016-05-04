<?php
    require_once "common/dbConnect.php";
    require_once "common/class.map.php";

    $map = new Map();
    $cid = -1;
    if (isset($_POST['cid']))
        $cid = intval($_POST['cid']);

    $center = $map -> load_center($cid);

    echo '<label>Name: </label><input type="text" class="form-control" id="name" name="name" value="' . $center['name'] . '">';
    echo '<label>Acronym: </label><input type="text" class="form-control" id="acronym" name="acronym" value="' . $center['acronym'] . '">';
    echo '<label>Color: </label><input type="color" class="form-control" id="color" name="color" value="' . $center['color'] . '">';


    echo '<br><center><input type="submit" value="Submit" onclick="submitEditCenter(' . $cid . ')"></center><br>';
?>


<br>
<center><a href="#" onclick="closePopup()">Close</a></center>