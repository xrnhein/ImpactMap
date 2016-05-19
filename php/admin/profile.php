<div class="span7 text-center">
	<?php
		$authenticated = false;

		if (!$authenticated) {
			echo "<div class='alert alert-danger'>";
			echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
			echo "Awaiting authentication";
			echo "</div>";
		}

		$name = "Testy McTestface";
		$email = "mctestface@ucdavis.edu";
		$phone = "xxx-xxxx";
		echo "<h2>" . $name . "</h2>";
		echo "<h2><small>" . $email . "</small></h2>";
		echo "<h2><small>" . $phone . "</small></h2><br>";
	?>
	<button type="button" class="btn btn-primary" onclick="updateProfile()">Update information</button>
</div>