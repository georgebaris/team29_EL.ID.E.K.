var top_researchers = document.getElementById("top_researchers_table");

setInterval(refresh, 1000);

function refresh(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_top_young_researchers.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			top_researchers.innerHTML = this.responseText;
		}
	};
	
	xhttp.send();
}