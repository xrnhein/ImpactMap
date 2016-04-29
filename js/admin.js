var selectedProjects = [];

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
        url: "php/add_project.php",
        success: popupCallback
    });
}

function submitNewProject() {
	$("#popup").hide();
	$.ajax({
        type: "POST",
        url: "php/process_add_project.php",
        data: {address: $("#address").val(),
        	   description: $("#description").val(),
        	   title: $("#title").val(),
        	   lat: $("#lat").val(),
        	   lng: $("#lng").val(),
        	   category: $("#category").val()},
        data_type: "json",
        success: function (data) {
        	loadProjects();
        }
    });
}

function editProject(pid) {
    $("#popup").show();
    $.ajax({
        type: "POST",
        data: {pid: pid},
        data_type: "json",
        url: "php/edit_project.php",
        success: popupCallback
    });
}

function submitEditProject(pid) {
    $("#popup").hide();
    $.ajax({
        type: "POST",
        url: "php/process_edit_project.php",
        data: {pid: pid,
               address: $("#address").val(),
               description: $("#description").val(),
               title: $("#title").val(),
               lat: $("#lat").val(),
               lng: $("#lng").val(),
               category: $("#category").val()},
        data_type: "json",
        success: function (data) {
            loadProjects();
        }
    });
}

function deleteProjects() {
    var projects = $('.delete:checkbox:checked').map(function () {
        return this.id;
    }).get();

    $.ajax({
        type: "POST",
        url: "php/delete_projects.php",
        data: {data: JSON.stringify(projects)}, 
        success: function (data) {
            loadProjects();
        }
    });
}

function closePopup() {
    $("#popup").hide();
}

function printCallback(data) {
    console.log(data);
}