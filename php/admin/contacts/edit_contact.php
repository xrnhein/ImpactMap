<?php
    /**
    * Populates a popup dialog with information about the chosen center
    */

    require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();
    $conid = -1;
    if (isset($_POST['conid']))
        $conid = intval($_POST['conid']);

    $contact = $map -> load_contact($conid);

    echo '<label>Name: </label><input type="text" class="form-control" id="name" name="name" value="' . $contact['name'] . '">';
    echo '<label>Email: </label><input type="text" class="form-control" id="email" name="email" value="' . $contact['email'] . '">';
    echo '<label>Phone: </label><input type="text" class="form-control" id="phone" name="phone" value="' . $contact['phone'] . '">';


    echo '<br><center><input type="submit" value="Submit" onclick="submitEditContact(' . $conid . ')"></center><br>';
?>


<br>
<center><a href="#" onclick="closePopup()">Close</a></center>