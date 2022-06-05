<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "elidek";
	
	$conn = mysqli_connect($server, $username, $password, $db_name);
	$query_start = "SELECT DISTINCT project.title, researcher.name, researcher.surname
FROM project, works_at_project as w, executive as e,researcher WHERE w.project_ID = project.ID and w.researcher_ID = researcher.ID and ";
	$query2 = " and not(e.name = ";
	$query3 = " and e.project_ID = project.ID)) ";
	$query4 = " and not(project.duration = ";
	$query5 = "))";
	$query6 = " and not(start_date = ";
	$query7 = "))";
	$query_end = "ORDER BY title;";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST"){
		$query = $query_start;
		
		// Check if executive filter is enabled
		if($_POST["executive_filter_en"] === "true"){
			$query .= "not(1";
		}
		else{
			$query .= "not(0";
		}
		$query .= $query2;
		
		$query .= "'" . $_POST["executive_text"] . "'" . $query3;
		
		
		// Check if duration filter is enabled
		if($_POST["duration_filter_en"] === "true"){
			$query .= "and not(1";
		}
		else{
			$query .= "and not(0";
		}
		$query .= $query4;
		
		$duration = $_POST["duration"];
		if($duration === "") $duration = "-1";
		$query .= $duration . $query5;
		
		
		// Check if starting date filter is enabled
		if($_POST["date_filter_en"] === "true"){
			$query .= "and not(1";
		}
		else{
			$query .= "and not(0";
		}
		$query .= $query6;
		
		$start_date = $_POST["start_date"];
		if($start_date === "") $start_date = "''";
		$query .= "'" . $start_date . "'" . $query7;
		
		$query .= $query_end;
		
		/*mysqli_query($conn, $query);*/
		
		$result = $conn->query($query);
		$rows = null;
		$found_proj = "";
		$str = "";
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