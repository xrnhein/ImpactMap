<table class="projects">
	<input type="submit" value="Import .csv"><input type="submit" value="Export .csv"><br><br>
	Max projects shown <input type="text" value="100"><br>
	View entries between <input type="text"> and <input type="text"><br>
	Only show deleted projects <input type="checkbox"><br><br>
	<tr>
		<th></th>
		<th>timestamp</th>
		<th>hid</th>
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

		$filtered = $map -> load_history($filters);

		for ($i = 0; $i < count($filtered); $i++) {
			echo "<tr>";
			echo "<td><input type='checkbox' class='delete' id='" . $filtered[$i]['hid'] . "'></td>";
			echo "<td class='clickable' onclick=viewHistory(" . $filtered[$i]['hid'] . ")> " . $filtered[$i]['time'] . " </td>";
			echo "<td class='clickable' onclick=viewHistory(" . $filtered[$i]['hid'] . ")> " . $filtered[$i]['hid'] . " </td>";
			echo "<td class='clickable' onclick=viewHistory(" . $filtered[$i]['hid'] . ")> " . $filtered[$i]['title'] . " </td>";
			echo "<td class='clickable' onclick=viewHistory(" . $filtered[$i]['hid'] . ")> " . $filtered[$i]['lat'] . " </td>";
			echo "<td class='clickable' onclick=viewHistory(" . $filtered[$i]['hid'] . ")> " . $filtered[$i]['lng'] . " </td>";
			echo "</tr>";
		}
	?>
</table>
<a href="#" onclick="restoreHistory()">Restore selected projects</a><br>
<a href="#" onclick="deleteHistory()">Delete forever</a><br><br>

Restore project table to <input type="text">