<table class="projects">
	<?php
		echo 'View table at: <input type="text" id="datetimepicker" value="' . $_POST['timestamp'] . '">';
	?>
	<input type='submit' value='Refresh' onclick='loadHistory()'><br>
	<tr>
		<th></th>
		<th>timestamp</th>
		<th>hid</th>
		<th>title</th>
		<th>lat</th>
		<th>lng</th>
	</tr>
	<?php
		/**
		* A table populated with entries in the History table that represent the Project table at a certain point in time. The time
		* the table will represent is $_POST['timestamp']. Each checbox stores the id of a history entry to facilitate recovering 
		* entries in the history. Clicking on an item in the history table calls viewHistory(hid) where hid is the id of that item
		* in the history table.
		*/

		require_once "../../common/dbConnect.php";
		require_once "../../common/class.map.php";

		$infinity = 1000000;

		$map = new Map();
		$filters = array();

		$filters['limit'] = $infinity;
		$filters['timestamp'] = $_POST['timestamp'];

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
<?php
	echo '<a href="#" onclick="restoreWholeTable(\'' . $_POST['timestamp'] . '\')">Restore whole table</a>';
?>