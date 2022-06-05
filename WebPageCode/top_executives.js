var top_executives = document.getElementById("top_executive_table");

setInterval(refresh_exec, 1000);

function refresh_exec(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_top_executives.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			top_executives.innerHTML = this.responseText;
		}
	};
	
	xhttp.send();
}