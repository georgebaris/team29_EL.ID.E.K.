var proj_avail_cont = document.getElementById("projects_found_container");

var date_filter_en = document.getElementById("date_checkbox");
var duration_filter_en = document.getElementById("duration_checkbox");
var executive_filter_en = document.getElementById("executive_checkbox");

var start_date_text_div = document.getElementById("start_date_div");
var duration = document.getElementById("duration_text");
var executive_filter_text = document.getElementById("executive_text");


function apply_filters(){
	// Check for errors
	if(date_filter_en.checked && !check_date()){
		var date_error = document.getElementById("date_error");
		date_error.style.display = "inline";
		return;
	}
	else{
		var date_error = document.getElementById("date_error");
		date_error.style.display = "none";
	}
	
	if(duration_filter_en.checked && !check_duration()){
		var duration_error = document.getElementById("duration_error");
		duration_error.style.display = "inline";
		return;
	}
	else{
		var duration_error = document.getElementById("duration_error");
		duration_error.style.display = "none";
	}
	
	if(!date_filter_en.checked){
		var start_date_inputs = start_date_text_div.getElementsByTagName("input");
		start_date_inputs[0].value = "";
		start_date_inputs[1].value = "";
		start_date_inputs[2].value = "";
	}
	if(!duration_filter_en.checked){
		duration.value = "";
	}
	
	
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "get_filtered.php", true);
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			proj_avail_cont.innerHTML = this.responseText;
		}
	};
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	
	var start_date_inputs = start_date_text_div.getElementsByTagName("input");
	var start_day = start_date_inputs[0].value;
	if(start_day.length < 2) start_day = "0" + start_day;
	var start_month = start_date_inputs[1].value;
	if(start_month.length < 2) start_month = "0" + start_month;
	var start_year = start_date_inputs[2].value;
	var start_date = start_year + "-" + start_month + "-" + start_day;
	
	var post_parameters = "date_filter_en=" + date_filter_en.checked + "&duration_filter_en=" + duration_filter_en.checked + "&executive_filter_en=" + executive_filter_en.checked
	+ "&duration=" + duration.value + "&executive_text=" + executive_filter_text.value + "&start_date=" + start_date;
	xhttp.send(post_parameters);
}


function check_date(){
	var start_date_inputs = start_date_text_div.getElementsByTagName("input");
	var start_day = start_date_inputs[0].value;
	if(start_day.length < 2) start_day = "0" + start_day;
	var start_month = start_date_inputs[1].value;
	if(start_month.length < 2) start_month = "0" + start_month;
	var start_year = start_date_inputs[2].value;
	var start_date = start_year + "-" + start_month + "-" + start_day;
	
	if(isNaN(start_day)) return false;
	if(isNaN(start_month)) return false;
	if(isNaN(start_year)) return false;
	
	return true;
}

function check_duration(){
	if(isNaN(duration.value)) return false;
	
	return true;
}