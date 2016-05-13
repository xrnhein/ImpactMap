<table class="projects">
	<input type="submit" value="Import .csv"><input type="submit" value="Export .csv"><br>
	<tr>
		<th></th>
		<th>pid</th>
		<th>title</th>
		<th>lat</th>
		<th>lng</th>
	</tr>
	<?php
		/**
		* The table of projects. Each checkbox stores the id of the project it's next to for deletion. Clicking on a project calls editProject(pid) where
		* pid is the id of that project.
		*/

		require_once "../../common/dbConnect.php";
		require_once "../../common/class.map.php";

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
<a href="#" onclick="editProject(-1)">Add a project</a><br>
<a href="#" onclick="deleteProjects()">Delete selected projects</a>
