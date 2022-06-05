var add_p = document.getElementById("add_project");

function add_project(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "add_project.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("Sent: " + this.responseText);
		}
	};
	
	var form = add_p.getElementsByClassName("form")[0];
	
	var fields = form.getElementsByClassName("field");
	var title = fields[0].getElementsByTagName("input")[0].value;
	var funds = fields[1].getElementsByTagName("input")[0].value;
	var start_day = fields[2].getElementsByTagName("input")[0].value;
	if(start_day.length < 2) start_day = "0" + start_day;
	var start_month = fields[2].getElementsByTagName("input")[1].value;
	if(start_month.length < 2) start_month = "0" + start_month;
	var start_year = fields[2].getElementsByTagName("input")[2].value;
	var end_day = fields[3].getElementsByTagName("input")[0].value;
	var end_month = fields[3].getElementsByTagName("input")[1].value;
	var end_year = fields[3].getElementsByTagName("input")[2].value;
	var start_date = start_year + "-" + start_month + "-" + start_day;
	console.log(start_date);
	var end_date = end_year + "-" + end_month + "-" + end_day;
	var summary = fields[4].getElementsByTagName("input")[0].value;
	
	var man_org = fields[5].getElementsByTagName("input")[0].value
	
	var sc_fields = fields[6].getElementsByTagName("input")[0].value;
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var post_parameters = "title=" + title + "&funds=" + funds + "&start_date=" + start_date + "&end_date=" + end_date + "&summary=" + summary + "&man_org=" + man_org + "&sc_fields=" + sc_fields;
	xhttp.send(post_parameters);
	
	console.log(end_date);
	/*console.log(name);
	console.log(surname);
	console.log(date);
	console.log(sex);*/
}