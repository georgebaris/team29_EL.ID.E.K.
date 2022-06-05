<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query = "SELECT e.name as exec_name, organization.name as name, sum(p.funds) as total_funds
FROM executive as e, project as p, organization,(SELECT firm.ID as firm_ID, project_ID
						FROM firm,manages
						WHERE firm.ID = manages.organization_ID 
						ORDER BY firm.ID) as proj_per_firm
WHERE proj_per_firm.project_ID = e.project_ID AND p.ID = e.project_ID AND organization.ID = firm_ID
GROUP BY firm_ID, e.name
ORDER BY total_funds DESC
LIMIT 5;
";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$result = $conn->query($query);
		$rows = null;
		$found_proj = "";
		$str = "<div class = 'row, first_row'>
				<div class = 'item'> Executive </div>
				<div class = 'item'> Firm </div>
				<div class = 'item'> Total </div>
			</div>";
		$rows_found = 0;
		
		while($project = mysqli_fetch_assoc($result)){
			$str .= "<div class = 'row'>
				<div class = 'item'>" . $project["exec_name"] . "</div>
				<div class = 'item'>"  . $project["name"] . "</div>
				<div class = 'item'>" . $project["total_funds"] . "</div>
			</div>";
		}
		
		echo $str;
	}
?>