<?php
	require_once "../../common/dbConnect.php";
	require_once "../../common/class.map.php";
?>
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
								<li><a href="#" onclick="selectAll()">Select all</a></li>
								<li><a href="#" onclick="unselectAll()">Unselect all</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#" onclick="updateProjects('hide')">Hide</a></li>
								<li><a href="#" onclick="updateProjects('show')">Show</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#" onclick="updateProjects('delete')">Delete</a></li>
							</ul>
						</div>
					</th>
					<th class="col-xs-1">Visible</th>
					<th class="col-xs-3">Title</th>
					<th class="col-xs-2">Status</th>
					<th class="col-xs-2">Start date</th>
					<th class="col-xs-3">Summary</th>
				</tr>
			</thead>
			<tbody>
				<?php
					/**
					* The table of projects. Each checkbox stores the id of the project it's next to for deletion. Clicking on a project calls editProject(pid) where
					* pid is the id of that project.
					*/

					//require_once "../../common/dbConnect.php";
					//require_once "../../common/class.map.php";

					$map = new Map();

					$projects = $map -> load_projects_full();

					for ($i = 0; $i < count($projects); $i++) {
						echo "<tr>";
						echo "<td class='col-xs-1'><input type='checkbox' class='delete' id='" . $projects[$i]['pid'] . "'></td>";
						echo "<td class='clickable col-xs-1' onclick=editProject(" . $projects[$i]['pid'] . ")><span class='glyphicon glyphicon-eye-open' aria-hidden='true' ";
						if ($projects[$i]['visible'] == FALSE)
							echo "style='opacity: 0.1;'";
						echo "></span></td>";
						echo "<td class='clickable col-xs-3' onclick=editProject(" . $projects[$i]['pid'] . ")> " . $projects[$i]['title'] . " </td>";
						echo "<td class='clickable col-xs-2' onclick=editProject(" . $projects[$i]['pid'] . ")> " . $STATUS[$projects[$i]['status']] . " </td>";
						echo "<td class='clickable col-xs-2' onclick=editProject(" . $projects[$i]['pid'] . ")> " . $projects[$i]['startDate'] . " </td>";
						echo "<td class='clickable col-xs-3' onclick=editProject(" . $projects[$i]['pid'] . ")> " . substr($projects[$i]['summary'], 0, 80) . "..." . " </td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="span7 text-center">
	<button type="button" class="btn btn-primary" onclick="editProject(-1)">Add a project</button>
	<button type="button" class="btn btn-default">Import .csv</button>
	<button type="button" class="btn btn-default" onclick="exportProject()"">Export .csv</button>
</div>
