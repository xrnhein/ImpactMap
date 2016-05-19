<?php
    /**
    * The edit project dialog. Everything is contained in the #popup div. It contains text fields and drop downs to specify all the data attributes for a project.
    * The project id of the project being edited is passed over as $_POST['pid']. If the pid is -1 that indicates that a projected is being added rather than edited.
    * The position variable in admin.js is set here, so that the map in the dialog will show the position of the chosen project.
    */

    require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();
    $pid = -1;
    if (isset($_POST['pid']))
        $pid = intval($_POST['pid']);

    $project = $map -> load_project_details($pid);
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add/Edit Project</h4>
        </div>
        <div class="modal-body">
            <?php
                echo '<label>Title: </label><input type="text" class="form-control" id="title" name="title" value="' . $project['title'] . '">';
                echo '<label>Center: </label><select type="text" class="form-control" id="cid" name="cid">';
                // Populate the list of centers
                $centers = $map->load_centers();
                for ($i = 0; $i < count($centers); $i++) {
                    echo "<option value='" . $centers[$i]['cid'] ."'";
                    if ($centers[$i]['cid'] == $project['cid'])
                        echo "selected='selected'";
                    echo ">" . $centers[$i]['name'] . " (" . $centers[$i]['acronym'] . ")</option>";
                }
                echo '</select>';
                echo '<label>Status: </label><select type="text" class="form-control" id="status" name="status">';
                for ($i = 0; $i < count($STATUS); $i++) {
                    echo "<option value='" . $i . "'";
                    if ($i == $project['status'])
                        echo "selected='selected'";
                    echo ">" . $STATUS[$i] . "</option>";
                }
                echo "</select>";
                echo '<label>Start Date: </label><input type="text" class="form-control" id="startDate" name="startDate" value="' . $project['startDate'] . '">';
                echo '<label>End Date: </label><input type="text" class="form-control" id="endDate" name="endDate" value="' . $project['endDate'] . '">';
                echo '<label>Building Name: </label><input type="text" class="form-control" id="buildingName" name="buildingName" value="' . $project['buildingName'] . '">';
                echo '<label>Address: </label><input type="text" class="form-control" id="address" name="address" value="' . $project['address'] . '">';
                echo '<label>Zip Code: </label><input type="text" class="form-control" id="zip" name="zip" value="' . $project['zip'] . '">';
                echo '<div id="projectPickerMap"></div>';
                echo '<label>Type: </label><select type="text" class="form-control" id="type" name="type" value="' . $project['type'] . '"></select>';
                echo '<label>Summary: </label><textarea class="form-control" id="summary"  name="summary" rows="10">' . $project['summary'] . '</textarea>';
                echo '<label>Link: </label><input type="text" class="form-control" id="link" name="link" value="' . $project['link'] . '">';
                echo '<label>Picture: </label><input type="text" class="form-control" id="pic" name="pic" value="' . $project['pic'] . '">';
                echo '<label>Contact: </label><select type="text" class="form-control" id="conid" name="conid">';
                $contacts = $map->load_contacts();
                for ($i = 0; $i < count($contacts); $i++) {
                    echo "<option value='" . $contacts[$i]['conid'] ."'";
                    if ($contacts[$i]['conid'] == $project['conid'])
                        echo "selected='selected'";
                    echo ">" . $contacts[$i]['name'] . "</option>";
                }
                echo "</select>";
                echo '<label>Funded by: </label><input type="text" class="form-control" id="fundedBy" name="fundedBy" value="' . $project['fundedBy'] . '">';
                echo '<label>Keywords: </label><input type="text" class="form-control" id="keywords" name="keywords" value="' . $project['keywords'] . '">';
                echo '<label>Visibility: </label><select type="text" class="form-control" id="visible" name="visible">';
                if ($project['visible'] == 1) {
                    echo "<option value='1' selected='selected'>Shown</option>";
                    echo "<option value='0'>Hidden</option>";
                } else {
                    echo "<option value='1'>Shown</option>";
                    echo "<option value='0' selected='selected'>Hidden</option>";
                }
                echo "</select>";


                // If we're editing a project then set the position variable for javascript to display the position on the map
                if ($pid != -1)
                    echo '<script>position = new google.maps.LatLng(' . $project['lat'] . ', ' . $project['lng'] . ');</script>';
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?php
                echo '<button type="button" class="btn btn-primary" onclick="submitEditProject(' . $pid . ')" data-dismiss="modal">Save changes</button>';
            ?>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->