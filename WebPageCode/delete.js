var del_p = document.getElementById("delete_project");

function delete_project(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "delete_project.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = del_p.getElementsByClassName("form")[0];
	var fields = form.getElementsByClassName("field");
	var title = fields[0].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("title=" + title);
}

var del_o = document.getElementById("delete_organization");

function delete_organization(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "delete_organization.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = del_o.getElementsByClassName("form")[0];
	var fields = form.getElementsByClassName("field");
	var name = fields[0].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name);
}