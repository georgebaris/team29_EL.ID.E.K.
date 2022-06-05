<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "SELECT first_name,second_name,count(project_ID) as number_of_projects
FROM(
	SELECT field1.name_of_field as first_name, field2.name_of_field as second_name, field1.project_ID
    FROM scientific_field_of_project as field1, scientific_field_of_project as field2
    WHERE field1.project_ID = field2.project_ID AND
        field1.name_of_field < field2.name_of_field 
    ) newtable
GROUP BY first_name
ORDER BY number_of_projects DESC, first_name
LIMIT 3;
";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$result = $conn->query($query);
		$rows = null;
		$found_proj = "";
		$str = "<div class = 'row, first_row'>
				<div class = 'item'> First Field </div>
				<div class = 'item'> Second Field </div>
				<div class = 'item'> # Projects </div>
			</div>";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			$str .= "<div class = 'row'>
				<div class = 'item'>" . $project["first_name"] . "</div>
				<div class = 'item'>"  . $project["second_name"] . "</div>
				<div class = 'item'>" . $project["number_of_projects"] . "</div>
			</div>";
		}
		
		echo $str;
	}
?>