<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "SELECT name,surname,num_of_projects
FROM(SELECT researcher.ID,name,surname,count(project.ID) as num_of_projects
	FROM project,researcher,works_at_project
	WHERE project_ID=project.ID AND researcher_ID=researcher.ID AND researcher.age<40 AND end_date < CURDATE()
	GROUP BY researcher.ID) as newtable
ORDER BY num_of_projects DESC, name
LIMIT 10;";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$result = $conn->query($query);
		$rows = null;
		$found_proj = "";
		$str = "<div class = 'row, first_row'>
				<div class = 'item'> Researcher </div>
				<div class = 'item'> Number of projects </div>
			</div>";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			$str .= "<div class = 'row'>
				<div class = 'item'>" . $project["name"] . " " . $project["surname"] . "</div>
				<div class = 'item'>"  . $project["num_of_projects"] . "</div>
			</div>";
		}
		
		echo $str;
	}
?>