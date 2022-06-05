<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = "select * from projects_per_researcher order by surname";

		$result = $conn->query($query);
		$rows = null;
		$found_res = "";
		$str = "";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			if($project["surname"] != $found_res){
				if($rows_found != 0) $str .= "</div></div>";
				echo $str;
				$str = "";
				$str .= "<div class = 'cont'><div class = 'project'>" . $project["surname"] . "</div>
			<div class = 'researchers'>";
				$found_res = $project["surname"];
			}
			$str .= "<div class = 'researcher'>" . $project["title"] . "</div>";
			$rows_found++;
		}
		$str .= "</div>";
		if($rows_found === 0) $str = "<div class = 'cont'><div class = 'project'> No projects found </div></div>";
		echo $str;
	}
?>