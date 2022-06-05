<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = "select ID from project where title = '" . $_POST["project"] . "';";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$proj_id = $ret["ID"];
		
		$query = "select max(ID) from executive";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$max = $ret["max(ID)"] + 1;
		
		$query = "insert into executive(ID, project_ID, name) values(" . $max . ", " . $proj_id . ", '" . $_POST["name"] . "');";
		$result = $conn->query($query);
		
		echo $proj_id;
		
	}
?>