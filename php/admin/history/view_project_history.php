<?php
    /**
    * The contents of the popup dialog for viewing a project in the History table. Nothing can be edited from here, only viewed.
    * The attributes of the project are loaded from the database and then displayed in the same format as the add/edit project dialog.
    */

    require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();
    $hid = -1;
    if (isset($_POST['hid']))
        $hid = intval($_POST['hid']);

    $filtered = $map -> load_history_details($hid);

    echo '<label>Title: </label><input type="text" class="form-control" id="title" name="title" value="' . $filtered['title'] . '" disabled="disabled">';
    echo '<label>Center: </label><select type="text" class="form-control" id="cid" name="cid" disabled="disabled">';
    $center = $map->load_center($filtered['cid']);
    echo "<option value='" . $center['cid'] ."' selected='selected'>" . $center['name'] . " (" . $center['acronym'] . ")</option></select>";
    echo '<label>Status: </label><select type="text" class="form-control" id="status" name="status" disabled="disabled" value="' . $filtered['status'] . '"></select>';
    echo '<label>Start Date: </label><input type="text" class="form-control" id="startDate" name="startDate" value="' . $filtered['startDate'] . '" disabled="disabled">';
    echo '<label>End Date: </label><input type="text" class="form-control" id="endDate" name="endDate" value="' . $filtered['endDate'] . '" disabled="disabled">';
    echo '<label>Building Name: </label><input type="text" class="form-control" id="buildingName" name="buildingName" value="' . $filtered['buildingName'] . '" disabled="disabled">';
    echo '<label>Address: </label><input type="text" class="form-control" id="address" name="address" value="' . $filtered['address'] . '" disabled="disabled">';
    echo '<label>Zip Code: </label><input type="text" class="form-control" id="zip" name="zip" value="' . $filtered['zip'] . '" disabled="disabled">';
    echo '<div id="projectPickerMap"></div>';
    echo '<label>Type: </label><select type="text" class="form-control" id="type" name="type" disabled="disabled" value="' . $filtered['type'] . '"></select>';
    echo '<label>Summary: </label><textarea class="form-control" id="summary"  name="summary" rows="10" disabled="disabled">' . $filtered['summary'] . '</textarea>';
    echo '<label>Link: </label><input type="text" class="form-control" id="link" name="link" value="' . $filtered['link'] . '" disabled="disabled">';
    echo '<label>Picture: </label><input type="text" class="form-control" id="pic" name="pic" value="' . $filtered['pic'] . '" disabled="disabled">';
    echo '<label>Contact Name: </label><input type="text" class="form-control" id="contactName" name="contactName" value="' . $filtered['contactName'] . '" disabled="disabled">';
    echo '<label>Contact Email: </label><input type="text" class="form-control" id="contactEmail" name="contactEmail" value="' . $filtered['contactEmail'] . '" disabled="disabled">';
    echo '<label>Contact Phone: </label><input type="text" class="form-control" id="contactPhone" name="contactPhone" value="' . $filtered['contactPhone'] . '" disabled="disabled">';

    // Set the position of the marker on the map
    if ($hid != -1)
        echo '<script>position = new google.maps.LatLng(' . $filtered['lat'] . ', ' . $filtered['lng'] . ')</script>';
?>


<br>
<center><a href="#" onclick="closePopup()">Close</a></center>