var orgs = document.getElementById("organizations_table");

setInterval(refresh_orgs, 1000);

function refresh_orgs(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_organizations.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			orgs.innerHTML = this.responseText;
		}
	};
	
	xhttp.send();
}