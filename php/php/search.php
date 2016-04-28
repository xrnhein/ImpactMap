<!-- SAMPLE AJAX -->

<script>

    $.ajax ({
        type: "POST",
        url: "/php/search.php",
        data: {
        },
        data_type: "json",
        success: function(data) {

        },
        complete: function() {

        }
    })

</script>

<?php

require_once "../common/dbConnect.php";
require_once "../common/class.map.php";

$map = new Map();
$filters = array();

if (isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    $result = $map -> search_suggest($keyword);
    echo json_encode($filtered);
}



?>