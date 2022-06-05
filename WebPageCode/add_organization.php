<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		// Send query to find the maximum id currently in databse
		$query = "select max(id) from organization;";
		$result = $conn->query($query);
		$ret = mysqli_fetch_assoc($result);
		$max_id = $ret["max(id)"] + 1;
		
		
		$query = "insert into organization(id, name, abbreviation, address_PC, address_street, address_city, address_number) values(";
		$query .= $max_id . ", '" . $_POST["name"] . "', '" . $_POST["abbreviation"] . "', " . $_POST["address_pc"] . ", '" . $_POST["address_street"] . "', '" . $_POST["address_city"] . "', " . $_POST["address_num"]. ");";
		echo $query;
		$result = $conn->query($query);
	}
?>