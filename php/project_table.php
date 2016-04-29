<table class="projects">
	<tr>
		<th></th>
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
			echo "<td><input type='checkbox' class='delete' id='" . $filtered[$i]['pid'] . "'></td>";
			echo "<td class='clickable' onclick=editProject(" . $filtered[$i]['pid'] . ")> " . $filtered[$i]['pid'] . " </td>";
			echo "<td class='clickable' onclick=editProject(" . $filtered[$i]['pid'] . ")> " . $filtered[$i]['title'] . " </td>";
			echo "<td class='clickable' onclick=editProject(" . $filtered[$i]['pid'] . ")> " . $filtered[$i]['lat'] . " </td>";
			echo "<td class='clickable' onclick=editProject(" . $filtered[$i]['pid'] . ")> " . $filtered[$i]['lng'] . " </td>";
			echo "</tr>";
		}
	?>
</table>
<a href="#" onclick="addProject()">Add a project</a><br>
<a href="#" onclick="deleteProjects()">Delete selected projects</a>