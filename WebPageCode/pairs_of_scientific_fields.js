var pairs = document.getElementById("pairs_table");

setInterval(refresh_pairs, 1000);

function refresh_pairs(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_pairs.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			pairs.innerHTML = this.responseText;
		}
	};
	
	xhttp.send();
}