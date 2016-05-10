<?php
    require_once "common/dbConnect.php";
    require_once "common/class.map.php";

    $map = new Map();
    $pid = -1;
    if (isset($_POST['pid']))
        $pid = intval($_POST['pid']);

    $filtered = $map -> load_project_details($pid);

    echo '<label>Title: </label><input type="text" class="form-control" id="title" name="title" value="' . utf8_encode($filtered['title']) . '">';
    echo '<label>Center: </label><select type="text" class="form-control" id="cid" name="cid">';
    $centers = $map->load_centers();
    for ($i = 0; $i < count($centers); $i++) {
        echo "<option value='" . $centers[$i]['cid'] ."'";
        if ($centers[$i]['cid'] == $filtered['cid'])
            echo "selected='selected'";
        echo ">" . $centers[$i]['name'] . " (" . $centers[$i]['acronym'] . ")</option>";
    }
    echo '</select>';
    echo '<label>Status: </label><select type="text" class="form-control" id="status" name="status" value="' . $filtered['status'] . '"></select>';
    echo '<label>Start Date: </label><input type="text" class="form-control" id="startDate" name="startDate" value="' . $filtered['startDate'] . '">';
    echo '<label>End Date: </label><input type="text" class="form-control" id="endDate" name="endDate" value="' . $filtered['endDate'] . '">';
    echo '<label>Building Name: </label><input type="text" class="form-control" id="buildingName" name="buildingName" value="' . $filtered['buildingName'] . '">';
    echo '<label>Address: </label><input type="text" class="form-control" id="address" name="address" value="' . utf8_encode($filtered['address']) . '">';
    echo '<label>Zip Code: </label><input type="text" class="form-control" id="zip" name="zip" value="' . $filtered['zip'] . '">';
    echo '<div id="projectPickerMap"></div>';
    echo '<label>Type: </label><select type="text" class="form-control" id="type" name="type" value="' . $filtered['type'] . '"></select>';
    echo '<label>Summary: </label><textarea class="form-control" id="summary"  name="summary" rows="10">' . utf8_encode($filtered['summary']) . '</textarea>';
    echo '<label>Link: </label><input type="text" class="form-control" id="link" name="link" value="' . $filtered['link'] . '">';
    echo '<label>Picture: </label><input type="text" class="form-control" id="pic" name="pic" value="' . $filtered['pic'] . '">';
    echo '<label>Contact Name: </label><input type="text" class="form-control" id="contactName" name="contactName" value="' . $filtered['contactName'] . '">';
    echo '<label>Contact Email: </label><input type="text" class="form-control" id="contactEmail" name="contactEmail" value="' . $filtered['contactEmail'] . '">';
    echo '<label>Contact Phone: </label><input type="text" class="form-control" id="contactPhone" name="contactPhone" value="' . $filtered['contactPhone'] . '">';

    if ($pid != -1)
        echo '<script>position = new google.maps.LatLng(' . $filtered['lat'] . ', ' . $filtered['lng'] . ')</script>';

    echo '<br><center><input type="submit" value="Submit" onclick="submitEditProject(' . $pid . ')"></center><br>';
?>


<br>
<center><a href="#" onclick="closePopup()">Close</a></center>