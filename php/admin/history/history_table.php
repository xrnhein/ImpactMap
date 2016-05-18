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
								<li><a href="#">Restore</a></li>
							</ul>
						</div>
					</th>
					<th class="col-xs-1">Visible</th>
					<th class="col-xs-2">Time</th>
					<th class="col-xs-2">Title</th>
					<th class="col-xs-2">Status</th>
					<th class="col-xs-2">Started</th>
					<th class="col-xs-2">Summary</th>
				</tr>
			</thead>
			<tbody>
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

					$history = $map -> load_history_full($filters);

					for ($i = 0; $i < count($history); $i++) {
						echo "<tr>";
						echo "<td class='col-xs-1'><input type='checkbox' class='delete' id='" . $history[$i]['hid'] . "'></td>";
						echo "<td class='clickable col-xs-1' onclick=editProject(" . $history[$i]['hid'] . ")><span class='glyphicon glyphicon-eye-open' aria-hidden='true' ";
						if ($history[$i]['visible'] == 1)
							echo "style='opacity: 0.2;'";
						echo "></span></td>";
						echo "<td class='col-xs-2' class='clickable' onclick=viewHistory(" . $history[$i]['hid'] . ")> " . $history[$i]['time'] . " </td>";
						echo "<td class='col-xs-2' class='clickable' onclick=viewHistory(" . $history[$i]['hid'] . ")> " . $history[$i]['title'] . " </td>";
						echo "<td class='col-xs-2' class='clickable' onclick=viewHistory(" . $history[$i]['hid'] . ")> " . $STATUS[$history[$i]['status']] . " </td>";
						echo "<td class='col-xs-2' class='clickable' onclick=viewHistory(" . $history[$i]['hid'] . ")> " . $history[$i]['startDate'] . " </td>";
						echo "<td class='col-xs-2' class='clickable' onclick=viewHistory(" . $history[$i]['hid'] . ")> " . substr($history[$i]['summary'], 0, 80) . "..." . " </td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="span7 text-center">
	<button type="button" class="btn btn-primary" onclick="restoreWholeTable()">Restore whole table</button>
</div>