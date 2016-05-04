var projectPickerMap;
var geocoder;
var marker;
var position;
var davis = {lat: 38.5449, lng: -121.7405};

function initMap() {
    projectPickerMap = new google.maps.Map($("#projectPickerMap").get(0), {
        center: davis,
        zoom: 8,
        disableDefaultUI: true
    });

    projectPickerMap.setOptions({styles: [ { featureType: "road", stylers: [ { visibility: "off" } ] },{ } ]});

    geocoder = new google.maps.Geocoder();

    if (position != null) {
        marker = new google.maps.Marker({
            map: projectPickerMap,
            position: position,
            draggable: true,
            title: "Drag me!"
        });
    }
}

$(document).ready( function() {
	$("#popup").hide();
});

function contentCallback(data) {
	$("#content").html(data);

}

function projectPopupCallback(data) {
    $("#popup").html(data);
    initMap();
    $("#address").keyup(function() {
        geocoder.geocode({
            address: $("#address").val()
        }, geocodeCallback);
    });
    $("#popup").scrollTop(0);
}

function centerPopupCallback(data) {
    $("#popup").html(data);
}

function userPopupCallback(data) {
    $("#popup").html(data);
}


function geocodeCallback(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        projectPickerMap.setCenter(results[0].geometry.location);
        if (marker == null) {
            marker = new google.maps.Marker({
                map: projectPickerMap,
                position: results[0].geometry.location,
                draggable: true,
                title: "Drag me!"
            });
        } else {
            marker.setPosition(results[0].geometry.location);
        }
    }
}

function loadProjects() {
    $.ajax({
        type: "POST",
        url: "php/project_table.php",
        success: contentCallback
    });
}

function editProject(pid) {
    openPopup();
    $.ajax({
        type: "POST",
        data: {pid: pid},
        data_type: "json",
        url: "php/edit_project.php",
        success: projectPopupCallback
    });
}

function submitEditProject(pid) {
    $.ajax({
        type: "POST",
        url: "php/submit_project_edit.php",
        data: {pid: pid,
               cid: $("#cid").val(),
               title: $("#title").val(),
               status: $("#status").val(),
               startDate: $("#startDate").val(),
               endDate: $("#endDate").val(),
               buildingName: $("#buildingName").val(),
               address: $("#address").val(),
               zip: $("#zip").val(),
               type: $("#type").val(),
               summary: $("#summary").val(),
               link: $("#link").val(),
               pic: $("#pic").val(),
               contactName: $("#contactName").val(),
               contactEmail: $("#contactEmail").val(),
               contactPhone: $("#contactPhone").val(),
               lat: marker.getPosition().lat(),
               lng: marker.getPosition().lng()},
        data_type: "json",
        success: function (data) {
            loadProjects();
        }
    });
    closePopup();
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

function loadUtilities() {
    $.ajax({
        type: "POST",
        url: "php/history_table.php",
        success: contentCallback
    });
}

function loadCenters() {
    $.ajax({
        type: "POST",
        url: "php/center_table.php",
        success: contentCallback
    });
}

function editCenter(cid) {
    openPopup();
    $.ajax({
        type: "POST",
        data: {cid: cid},
        data_type: "json",
        url: "php/edit_center.php",
        success: centerPopupCallback
    });
}

function submitEditCenter(cid) {
    $.ajax({
        type: "POST",
        url: "php/submit_center_edit.php",
        data: {cid: cid,
               name: $("#name").val(),
               acronym: $("#acronym").val(),
               color: $("#color").val()},
        data_type: "json",
        success: function (data) {
            loadCenters();
        }
    });
    closePopup();
}

function deleteCenters() {
    var centers = $('.delete:checkbox:checked').map(function () {
        return this.id;
    }).get();

    $.ajax({
        type: "POST",
        url: "php/delete_centers.php",
        data: {data: JSON.stringify(centers)}, 
        success: function (data) {
            loadCenters();
        }
    });
}

function loadUsers() {
    $.ajax({
        type: "POST",
        url: "php/user_table.php",
        success: contentCallback
    });
}

function editUser(uid) {
    openPopup();
    $.ajax({
        type: "POST",
        data: {uid: uid},
        data_type: "json",
        url: "php/edit_user.php",
        success: userPopupCallback
    });
}

function submitEditUser(uid) {
    $.ajax({
        type: "POST",
        url: "php/submit_user_edit.php",
        data: {uid: uid,
               admin: ($("#admin").is(":checked")) ? 1 : 0,
               cas: ($("#cas").is(":checked")) ? 1 : 0},
        data_type: "json",
        success: function (data) {
            loadUsers();
        }
    });
    closePopup();
}

function deleteUsers() {
    var users = $('.delete:checkbox:checked').map(function () {
        return this.id;
    }).get();

    $.ajax({
        type: "POST",
        url: "php/delete_users.php",
        data: {data: JSON.stringify(users)}, 
        success: function (data) {
            loadUsers();
        }
    });
}

function openPopup() {
    $("#popup").show();
}

function closePopup() {
    $("#popup").hide();
    $("#popup").html("");
    marker = null;
    position = null;
}

function changePassword() {
    $.ajax({
        type: "POST",
        url: "php/change_password.php",
        success: contentCallback
    });
}

function printCallback(data) {
    console.log(data);
}