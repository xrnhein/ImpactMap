<table class="projects">
	<tr>
		<th></th>
		<th>cid</th>
		<th>name</th>
		<th>acronym</th>
		<th>color</th>
	</tr>
	<?php
		require_once "../../common/dbConnect.php";
		require_once "../../common/class.map.php";

		$map = new Map();

		$centers = $map -> load_centers();

		for ($i = 0; $i < count($centers); $i++) {
			echo "<tr>";
			if ($map->center_referred_to($centers[$i]['cid'])) {
				echo "<td><input type='checkbox' class='delete' id='" . $centers[$i]['cid'] . "' disabled='disabled' data-toggle='tooltip' title='Unable to delete this center since a project refers to it'></td>";
			} else {
				echo "<td><input type='checkbox' class='delete' id='" . $centers[$i]['cid'] . "'></td>";
			}
			
			echo "<td class='clickable' onclick=editCenter(" . $centers[$i]['cid'] . ")> " . $centers[$i]['cid'] . " </td>";
			echo "<td class='clickable' onclick=editCenter(" . $centers[$i]['cid'] . ")> " . $centers[$i]['name'] . " </td>";
			echo "<td class='clickable' onclick=editCenter(" . $centers[$i]['cid'] . ")> " . $centers[$i]['acronym'] . " </td>";
			echo "<td class='clickable' onclick=editCenter(" . $centers[$i]['cid'] . ") style='color: " . $centers[$i]['color'] . "'> " . $centers[$i]['color'] . " </td>";
			echo "</tr>";
		}
	?>
</table>
<a href="#" onclick="editCenter(-1)">Add a center</a><br>
<a href="#" onclick="deleteCenters()">Delete selected centers</a>