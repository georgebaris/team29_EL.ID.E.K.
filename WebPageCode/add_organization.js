var add_o = document.getElementById("add_organization");

function add_organization(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "add_organization.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = add_o.getElementsByClassName("form")[0];
	
	var fields = form.getElementsByClassName("field");
	var name = fields[0].getElementsByTagName("input")[0].value;
	var abbreviation = fields[1].getElementsByTagName("input")[0].value;
	var address_pc = fields[2].getElementsByTagName("input")[0].value;
	var address_street = fields[3].getElementsByTagName("input")[0].value;
	var address_city = fields[4].getElementsByTagName("input")[0].value;
	var address_num = fields[5].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name + "&abbreviation=" + abbreviation + "&address_pc=" + address_pc + "&address_street=" + address_street + "&address_city=" + address_city + "&address_num=" + address_num);
	
	
	
	/*console.log(name);
	console.log(surname);
	console.log(date);
	console.log(sex);*/
}