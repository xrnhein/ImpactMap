$(document).ready( function() {
	$("#popup").hide();
});

function loadProjects() {
	$.ajax({
        type: "POST",
        url: "php/project_table.php",
        success: contentCallback
    });
}

function contentCallback(data) {
	$("#content").html(data);

}

function popupCallback(data) {
	$("#popup").html(data);
}

function addProject() {
	$("#popup").show();
	$.ajax({
        type: "POST",
        url: "php/add_temp.php",
        success: popupCallback
    });
}

function submitNewProject() {
		
	$("#popup").hide();

console.log($("#address").val());

	$.ajax({
        type: "POST",
        url: "php/add_project.php",
        data: {address: $("#address").val(),
        	   description: $("#description").val(),
        	   title: $("#title").val(),
        	   lat: $("#lat").val(),
        	   lng: $("#lng").val(),
        	   category: $("#category").val()},
        data_type: "json",
        success: function (data) {
        	console.log(data);
        	loadProjects();
        }
    });
}