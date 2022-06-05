<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query1 = "SELECT DISTINCT title,name,surname
FROM project as p,works_at_project as w,researcher,scientific_field_of_project as s
WHERE s.name_of_field = '";
	$query2 = "' AND
	p.ID = s.project_ID AND
	w.researcher_ID = researcher.ID AND 
	w.project_ID = p.ID AND
	end_date > CURDATE();";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = $query1 . $_POST["scientific_field_name"] . $query2;
		$result = $conn->query($query);
		$rows = null;
		$str = "";
		$found_proj = "";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			if($project["title"] != $found_proj){
				if($rows_found != 0) $str .= "</div></div>";
				echo $str;
				$str = "";
				$str .= "<div class = 'cont'><div class = 'project'>" . $project["title"] . "</div>
			<div class = 'researchers'>";
				$found_proj = $project["title"];
			}
			$str .= "<div class = 'researcher'>" . $project["name"] . " " . $project["surname"] . "</div>";
			$rows_found++;
		}
		$str .= "</div>";
		if($rows_found === 0) $str = "<div class = 'cont'><div class = 'project'> No projects found </div></div>";
		echo $str;
	}
?>