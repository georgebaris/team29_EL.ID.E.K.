var add_r = document.getElementById("add_researcher");

function add_researcher(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "add_researcher.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = add_r.getElementsByClassName("form")[0];
	var fields = form.getElementsByClassName("field");
	var name = fields[0].getElementsByTagName("input")[0].value;
	var surname = fields[1].getElementsByTagName("input")[0].value;
	var day = fields[2].getElementsByTagName("input")[0].value;
	if(day.length < 2)day = "0" + day;
	var month = fields[2].getElementsByTagName("input")[1].value;
	if(month.length < 2)month = "0" + month;
	var year = fields[2].getElementsByTagName("input")[2].value;
	var date = year + "-" + month + "-" + day;
	var sex = fields[3].getElementsByTagName("select")[0].value;
	var projects = fields[4].getElementsByTagName("input")[0].value;
	var org = fields[5].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name + "&surname=" + surname + "&date=" + date + "&sex=" + sex + "&projects=" + projects + "&org=" + org);
	
	
	
	/*console.log(name);
	console.log(surname);
	console.log(date);
	console.log(sex);*/
}