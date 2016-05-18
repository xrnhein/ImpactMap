<div class="row">
	<div class="panel panel-default">
		<table class="table table-hover table-fixed">
			<thead>
				<tr>
					<th class="col-xs-1">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="#">Select all</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">Delete</a></li>
							</ul>
						</div>
					</th>
					<th class="col-xs-4">Name</th>
					<th class="col-xs-4">Email</th>
					<th class="col-xs-3">Phone</th>
				</tr>
			</thead>
			<tbody>
				<?php
					/**
					* The table of users. Clicking on a user in the table will call editUser(uid) where uid is the id of that user in the table.
					* Checkboxes store uids as well for deletion. Clicking on add user will call the same editUser(uid) function except with a
					* uid of -1.
					*/

					require_once "../../common/dbConnect.php";
					require_once "../../common/class.map.php";

					$map = new Map();

					$users = $map -> load_users();

					for ($i = 0; $i < count($users); $i++) {
						echo "<tr>";
						echo "<td class='col-xs-1'><input type='checkbox' class='delete' id='" . $users[$i]['uid'] . "'></td>";			
						echo "<td class='col-xs-4 clickable' onclick=editUser(" . $users[$i]['uid'] . ")> " . $users[$i]['name'] . " </td>";
						echo "<td class='col-xs-4 clickable' onclick=editUser(" . $users[$i]['uid'] . ")> " . $users[$i]['email'] . " </td>";
						echo "<td class='col-xs-3 clickable' onclick=editUser(" . $users[$i]['uid'] . ")> " . "xxx" . " </td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>