p_per_r = document.getElementById("researcher_per_proj_cont");

setInterval(load_researchers, 1000);

function load_researchers(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_proj_per_r.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			p_per_r.innerHTML = this.responseText;
		}
	};
	xhttp.send();
}