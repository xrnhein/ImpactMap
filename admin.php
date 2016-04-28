<html>
	<head>
		<meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	    <!-- Optional theme -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<link rel="stylesheet" href="css/admin.css">
		<link rel="stylesheet" href="css/project_table.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="js/admin.js"></script>
	</head>
	<body>
		<div id="navbar">
			<table>
				<?php

					// This is just temporary until we have a database of users
					$usertype = "admin";

					echo "<tr><td>Change password</td></tr>";
					if ($usertype == "admin") {
						echo "<tr><td>Authenticate a new user</td></tr>";
						echo "<tr><td>Change user permissions</td></tr>";
					}
					echo "<tr><td onclick='loadProjects()'>Update projects</td></tr>";
					echo "<tr><td>Restore old project entries</td></tr>";
					
				?>
			</table>
		</div>
		<div id="content">
		</div>
		<div id="popup">
		</div>
	</body>
</html>