<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = "delete from project where title = '" . $_POST["title"] . "';";
		$result = $conn->query($query);
	}
?>