<table class="table table-hover">
	<thead>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
		</tr>
	</thead>
	<?php

		/** 
		* The table is populated with contacts from the Center database. Clicking a center calls editContact(conid) with the center's id. Checkboxes also store center ids for deletion.
		*/

		require_once "../../common/dbConnect.php";
		require_once "../../common/class.map.php";

		$map = new Map();

		$contacts = $map -> load_contacts();

		for ($i = 0; $i < count($contacts); $i++) {
			echo "<tr>";
			if ($map->center_referred_to($contacts[$i]['conid'])) {
				echo "<td><input type='checkbox' class='delete' id='" . $contacts[$i]['conid'] . "' disabled='disabled' data-toggle='tooltip' title='Unable to delete this contact since a project refers to it'></td>";
			} else {
				echo "<td><input type='checkbox' class='delete' id='" . $contacts[$i]['conid'] . "'></td>";
			}
			
			echo "<td class='clickable' onclick=editContact(" . $contacts[$i]['conid'] . ")> " . $contacts[$i]['name'] . " </td>";
			echo "<td class='clickable' onclick=editContact(" . $contacts[$i]['conid'] . ")> " . $contacts[$i]['email'] . " </td>";
			echo "<td class='clickable' onclick=editContact(" . $contacts[$i]['conid'] . ")> " . $contacts[$i]['phone'] . " </td>";
			echo "</tr>";
		}
	?>
</table>
<div class="span7 text-center">
	<button type="button" class="btn btn-primary" onclick="editContact(-1)">Add a center</button>
	<button type="button" class="btn btn-danger" onclick="deleteContacts()">Delete selected contacts</button>
</div>