<table class="projects">
	<tr>
		<th>pid</th>
		<th>title</th>
		<th>lat</th>
		<th>lng</th>
	</tr>
	<?php
		require_once "common/dbConnect.php";
		require_once "common/class.map.php";

		$infinity = 1000000;

		$map = new Map();
		$filters = array();

		$filters['limit'] = $infinity;

		$filtered = $map -> load_projects($filters);

		for ($i = 0; $i < count($filtered); $i++) {
			echo "<tr>";
			echo "<td> " . $filtered[$i]['pid'] . " </td>";
			echo "<td> " . $filtered[$i]['title'] . " </td>";
			echo "<td> " . $filtered[$i]['lat'] . " </td>";
			echo "<td> " . $filtered[$i]['lng'] . " </td>";
			echo "</tr>";
		}
	?>
</table>
<a href="#" onclick="addProject()">Add a project</a>