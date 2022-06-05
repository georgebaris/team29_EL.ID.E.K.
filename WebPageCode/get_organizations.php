<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "SELECT org_ID,organization.name
FROM organization,(SELECT table1.org_ID,table1.num_of_proj
					FROM (SELECT EXTRACT(YEAR from project.start_date) as years,
                        		organization.ID as org_ID,count(project.ID) as num_of_proj
						FROM manages,organization,project
						WHERE organization.ID = organization_ID AND project.ID = project_ID
						GROUP BY years,org_ID) as table1, 
    					(SELECT EXTRACT(YEAR from project.start_date) as years,
                        		organization.ID as org_ID,count(project.ID) as num_of_proj
						FROM manages,organization,project
						WHERE organization.ID = organization_ID AND project.ID = project_ID
						GROUP BY years,org_ID) as table2
					WHERE table1.org_ID = table2.org_ID AND
						table1.num_of_proj = table2.num_of_proj AND
						table1.years - table2.years = 1) as newtable
WHERE org_ID = organization.ID AND num_of_proj>=10;";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$result = $conn->query($query);
		$rows = null;
		$found_proj = "";
		$str = "<div class = 'row, first_row'>
				<div class = 'item'> Organizations </div>
			</div>";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			$str .= "<div class = 'row'>
				<div class = 'item'>" . $project["name"] . "</div>
			</div>";
		}
		
		echo $str;
	}
?>