<?php 
include '../db/config.php';

$method = $_POST['method'];
if ($method == 'fetch_progress_max') {
	$ircs_line = $_POST['ircs_line'];
	$line = $_POST['line'];

	$query = "SELECT takt_secs_DB FROM pcs_plan WHERE IRCS_Line = '$ircs_line' AND Line = '$line' AND Status = 'Pending'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		foreach($stmt->fetchALL() as $x){
			echo $x['takt_secs_DB'];
			
			
		}
	}
}
$conn = NULL;
?>