<?php
    /** 
    * Called when the root admin wants to edit the properties of a user. The id of the user to edit is sent over via POST.
    * If uid == -1 that indicates that a new user is being added to the system.
    */

    require_once "../../common/dbConnect.php";
    require_once "../../common/class.map.php";

    $map = new Map();
    $uid = -1;
    if (isset($_POST['uid']))
        $uid = intval($_POST['uid']);

    $user = $map -> load_user($uid);

    echo '<label>Email: </label><input type="text" class="form-control" disabled="disabled" id="email" name="email" value="' . $user['email'] . '">';
    echo '<label>Allow CAS login only: </label><input type="checkbox" class="form-control" id="cas" name="cas"';
    if ($user['cas'])
        echo 'checked="checked"';
    echo '">';
    echo '<label>Administrator: </label><input type="checkbox" class="form-control" id="admin" name="admin"';
    if ($user['admin'])
        echo 'checked="checked"';
    echo '">';


    echo '<br><center><input type="submit" value="Submit" onclick="submitEditUser(' . $uid . ')"></center><br>';
?>

<br>
<center><a href="#" onclick="closePopup()">Close</a></center>