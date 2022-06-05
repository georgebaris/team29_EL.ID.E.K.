var no_deliv = document.getElementById("no_deliv");

setInterval(refresh, 1000);

function refresh(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_no_deliv.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			no_deliv.innerHTML = this.responseText;
		}
	};
	
	xhttp.send();
}