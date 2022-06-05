var add_e = document.getElementById("add_executive");

function add_executive(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "add_executive.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = add_e.getElementsByClassName("form")[0];
	var fields = form.getElementsByClassName("field");
	var name = fields[0].getElementsByTagName("input")[0].value;
	var project = fields[1].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name + "&project=" + project);
}