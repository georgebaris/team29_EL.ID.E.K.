<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		// Check if project with this title exists
		$query = "select title from project where title = '" . $_POST["title"] . "';";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		echo $ret["title"];
		$flag = false;
		if(strlen($ret["title"]) > 0) $flag = true;
		
		
		// Send query to find the maximum id currently in databse
		$query = "select max(id) from project;";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$max_id = $ret["max(id)"] + 1;
		
		if($flag === false){
			$query = "insert into project(id, title, funds, start_date, end_date, summary, duration) values(";
			$query .= $max_id . ", '" . $_POST["title"] . "', " . $_POST["funds"] . ", '" . $_POST["start_date"] . "', '" . $_POST["end_date"] . "', '" . $_POST["summary"] . "', 0);";
			echo $query;
			$result = $conn->query($query);
			
			$query = "UPDATE project SET duration = EXTRACT(YEAR FROM end_date) - EXTRACT(YEAR FROM start_date);";
			$result = $conn->query($query);
		}
		
		$query = "select ID from project where title = '" . $_POST["title"] . "';";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$proj_id = $ret["ID"];
		
		
		$query = "select ID from organization where name = '" . $_POST["man_org"] . "';";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$org_id = $ret["ID"];
		
		$query = "insert into manages(project_ID, organization_ID) values(" . $proj_id . ", " . $org_id . ");";
		$conn->query($query);
		
		// Add project to scientific fields
		$fields = explode(",", $_POST["sc_fields"]);
		foreach($fields as $f){
			$query = "insert into scientific_field_of_project(project_ID, name_of_field) values(" . $proj_id . ", '" . $f . "');";
			echo $query;
			$result = $conn->query($query);
		}
	}
?>