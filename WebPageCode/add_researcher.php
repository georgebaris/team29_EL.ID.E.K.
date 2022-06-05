<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		// Check if researcher in database
		$query = "select ID from researcher where name = '";
		$query .= $_POST["name"] . "' and surname = '" . $_POST["surname"] . "' and date_of_birth = '" . $_POST["date"] . "' and sex = '" . $_POST["sex"] . "';";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		
		// Send query to find the maximum id currently in database
		if(strlen($ret["ID"]) <= 0){
			$query = "select max(id) from researcher;";
			$result = $conn->query($query);
			$ret = mysqli_fetch_assoc($result);
			$max_id = $ret["max(id)"] + 1;
			
			
			$query = "insert into researcher(id, name, surname, date_of_birth, sex, age) values(";
			$query .= $max_id . ", '" . $_POST["name"] . "', '" . $_POST["surname"] . "', '" . $_POST["date"] . "', '" . $_POST["sex"] . "', 0);";
			echo $query;
			$result = $conn->query($query);
			
			// Add researcher to organization
			$org = $_POST["org"];
			$query = "select ID from organization where name = '" . $org . "';";
			$result = $conn->query($query);
			$ret = mysqli_fetch_assoc($result);
			$org_id = $ret["ID"];
			$query = "insert into works_at(organization_ID, researcher_ID, starting_date) values(" . $org_id . ", " . $max_id . ",'0-0-5');";
			echo $query;
			$result = $conn->query($query);
			
			// Add researcher to projects
			$projects = explode(",", $_POST["projects"]);
			foreach($projects as $proj){
				$query = "select ID from project where title = '" . $proj . "';";
				$result = $conn->query($query);
				$ret = mysqli_fetch_assoc($result);
				$proj_id = $ret["ID"];
				$query = "insert into works_at_project(researcher_ID, project_ID) values(" . $max_id . ", " . $proj_id . ");";
				$result = $conn->query($query);
				echo $query;
			}
		}
		$query = "UPDATE researcher SET age = YEAR(CURDATE()) - EXTRACT(YEAR FROM date_of_birth);";
		$result = $conn->query($query);
	}
?>