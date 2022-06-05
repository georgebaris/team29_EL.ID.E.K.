var proj_per_field_cont = document.getElementById("projects_per_field_found_container");

function find_projects(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_projects_per_field.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			proj_per_field_cont.innerHTML = this.responseText;
		}
	};
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	
	var field = document.getElementById("field_name").value;
	
	var post_parameters = "scientific_field_name=" + field;
	xhttp.send(post_parameters);
}