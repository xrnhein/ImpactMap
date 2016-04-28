<html>
	<head>
	    <!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="css/TableCSSCode.css">

	</head>
	<body>
		<table class="CSSTableGenerator">
			<tr>
				<td>pid</td>
				<td>title</td>
				<td>lat</td>
				<td>lng</td>
			</tr>
			<?php
				require_once "php/common/dbConnect.php";
				require_once "php/common/class.map.php";

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
		<a href="add_temp.php">Add a project</a>
	</body>
</html>