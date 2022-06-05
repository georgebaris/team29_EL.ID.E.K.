<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "SELECT ID,name,surname, count(project_ID) as num_of_proj
FROM(
    SELECT DISTINCT researcher.ID,name,surname,w.project_ID
    FROM project,works_at_project as w ,researcher,deliverable
    WHERE w.project_ID = project.ID AND
        researcher_ID = researcher.ID AND
        w.project_ID NOT IN (SELECT project_ID
                             FROM deliverable) 
    ) newtable
GROUP BY ID
ORDER BY num_of_proj DESC, name
LIMIT 5;";
	
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
				<div class = 'item'>" . $project["num_of_proj"] . "</div>
			</div>";
		}
		
		echo $str;
	}
?>