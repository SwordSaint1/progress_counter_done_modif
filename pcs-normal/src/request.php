<?php

include '../db/config.php';
include '../db/config.ora.php';

if(isset($_POST['request'])){
	$request = $_POST['request'];
	if($request == "getPlan"){
		$carmaker = $_POST['carmaker'];
		$sql = " 
			SELECT *
			FROM pcs_plan 
			WHERE Carmodel 
			LIKE '%".$carmaker."%' 
			AND Status = 'Pending' 
		";
		$plans = $db->getQuery($sql);
		if ($plans) {
			foreach ($plans as $i => $p) {
					$IRCS_Line = $p['IRCS_Line'];
					$Actual_Target = 0;
					$IRCS_IP = $p['IP_address'];
					$started = $p['actual_start_DB'];
					$q = "
						SELECT COUNT(*) AS c
						FROM IRCS.T_PACKINGWK 
						WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') 
						AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";
					$stid = oci_parse($conn3, $q);
					oci_execute($stid);
					while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
						$Actual_Target = $row->C;
					}
					$Target = $p['Target'];
					$Remaining_Target = $Target - $Actual_Target;
					$class = '';
					if($Actual_Target > $Target){
						$Remaining_Target = '+'.abs($Target - $Actual_Target);
					}else{
						$Remaining_Target = $Target - $Actual_Target;
					}
					if($Actual_Target >= $Target){
						$class = 'tr-met';
					}else{
						$class = 'tr-unmet';
					}
					echo '<tr class="'.$class.' tr-click" data-id="'.$p['ID'].'">';
					echo '<td>'.$p['Line'].'</td>';
					echo '<td>'.$p['Target'].'</td>';
					echo '<td>'.$Actual_Target.'</td>';
					echo '<td>'.$Remaining_Target.'</td>';
					echo '</tr>';
			}
		}
	}else if($request == "getPlanLine"){
		$IRCS_Line = $_POST['registlinename'];
		$last_takt = $_POST['last_takt'];
		$sql = " 
			SELECT *
			FROM pcs_plan 
			WHERE IRCS_Line = '".$IRCS_Line."' 
			AND Status = 'Pending' 
		";
		$line = $db->getQuery($sql)[0];

		$lot_no = explode(',', $line['lot_no']);
		$Target = $line['Target'];
		$IRCS_IP = $line['IP_address'];
		$Actual_Target = 0;
		$takt = $line['takt_secs_DB'];
		$started = $line['actual_start_DB'];
		$q = "SELECT COUNT(*) AS c
			FROM IRCS.T_PACKINGWK 
			WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";
		// $q = "
		// 	SELECT COUNT(*) AS c
		// 	FROM IRCS.T_PACKINGWK 
		// 	WHERE REGISTLINENAME = '".$IRCS_Line."'
		// 	AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS')  AND IPADDRESS like '".$IRCS_IP."' AND PACKINGBOXCARDJUDGMENT = '1'";
	
		$stid = oci_parse($conn3, $q);
		oci_execute($stid);
		while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$Actual_Target = $row->C;
		}

		$Remaining_Target = $Actual_Target - $Target;

		if(!$Target){
			$Target = 0;
		}

		$lots = array();
		// $q = "
		// 	SELECT DISTINCT LOT
		// 	FROM IRCS.T_PACKINGWK 
		// 	WHERE REGISTLINENAME = '".$IRCS_Line."'
		// 	AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND IPADDRESS like '".$IRCS_IP."' AND PACKINGBOXCARDJUDGMENT = '1'";
		$q = "SELECT DISTINCT LOT
			FROM IRCS.T_PACKINGWK 
			WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";
	
		$stid = oci_parse($conn3, $q);
		oci_execute($stid);
		while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$lots[] = $row->LOT;
		}

		$lot_nos = implode(',', array_unique(array_merge($lots,$lot_no)));

		$p = array(
			"plan" => $Target,
			"actual" => $Actual_Target,
			"remaining" => $Remaining_Target,
			"takt" => $takt,
			"started" => $started,
			"lot" => $lot_nos
		);
		//UPDATE PLAN
		$added_target_formula = "FLOOR(TIME_TO_SEC(TIMEDIFF(NOW(), last_update_DB)) / takt_secs_DB)";
		$sql = " UPDATE pcs_plan SET Target = ".$Target."+".$added_target_formula.", Actual_Target = '".$Actual_Target."' ,Remaining_Target = '".$Remaining_Target."', last_takt_DB = '".$last_takt."', last_update_DB = NOW(), lot_no = '".$lot_nos."' WHERE IRCS_Line = '".$IRCS_Line."' AND Status = 'Pending' AND is_paused = 'NO' ";
		if($db->execQuery($sql)){
			header("content-type: application/json ");
			echo json_encode($p);
		}
	}else if($request == "updateTakt"){
		$IRCS_Line = $_POST['registlinename'];
		$added_takt_plan = $_POST['added_takt_plan'];
		$sql = " UPDATE pcs_plan SET Target = (Target+1) WHERE IRCS_Line = '".$IRCS_Line."' AND Status = 'Pending' ";
		if($db->execQuery($sql)){
			echo 'true';
		}
	}else if($request == "endTarget"){
		$IRCS_Line = $_POST['registlinename'];
		$sql = " UPDATE pcs_plan SET Status = 'Done', ended_DB = NOW() WHERE IRCS_Line = '".$IRCS_Line."' AND Status = 'Pending' ";
		if($db->execQuery($sql)){
			echo 'true';
		}
	}else if($request == "addTarget"){
		$registlinename = $_POST['registlinename'];
		$time_start = date('Y-m-d').' '.$_POST['time_start'];
		// IF PCS SET TO EARLY MORNING BEFFORE 8 DATE WILL SET THE YESTERDAY
		if(strtotime($_POST['time_start']) < strtotime('07:50:00')){
			$date_now = date('Y-m-d');
			$new_date_to = new Date($date_now);
			$new_date_to->modify("-1 day");
			$to = $new_date_to->format("Y-m-d");
			$date_actual_start = $to.' '.$_POST['time_start'];
		}else{
			$date_actual_start = date('Y-m-d').' '.$_POST['time_start'];
		}
		$plan = $_POST['plan'];
		$hrs = str_pad($_POST['hrs'], 2, '0', STR_PAD_LEFT);
		$mins = str_pad($_POST['mins'], 2, '0', STR_PAD_LEFT);
		$secs = str_pad($_POST['secs'], 2, '0', STR_PAD_LEFT);
		if($hrs == ""){
			$hrs = "00";
		}
		if($mins == ""){
			$mins = "00";
		}
		if($secs == ""){
			$secs = "00";
		}
		$takt_time = $hrs.':'.$mins.':'.$secs;
		$sql = "SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
		$line_name = $db->getQuery($sql)[0]['line_name'];
		$IP_address = $db->getQuery($sql)[0]['IP_address'];
		$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$line_name."%'";
		// $car_maker = $db2->getQuery($sql)[0]['line_DB'];
		// $car_maker = trim(substr($car_maker, 0, -4));
		$car_maker_name = explode('_',$registlinename);
		$car_maker = $car_maker_name[0];
		$takt_secs = $db->TimeToSec($takt_time);
		$status = "Pending";
		$sql = "INSERT INTO pcs_plan 
		(Carmodel, Line, Target, Status, IRCS_Line, datetime_DB, takt_secs_DB, actual_start_DB, last_update_DB, IP_address) VALUES 
		('".$car_maker."','".$line_name."','".$plan."','".$status."', '".$registlinename."', NOW(), ".$takt_secs.", '".$date_actual_start."', NOW(), '$IP_address')";
		if($db->execQuery($sql)){
			header("location: ../line.php?registlinename=".$registlinename);
		}
	}else if($request == "getLineName"){
		$registlinename = $_POST['registlinename'];
		$q = "SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
		$line_name = $db->getQueryOne($q)['line_name'];
		echo $line_name;
	}else if($request == "setPaused"){
		$registlinename = $_POST['registlinename'];
		$is_paused = $_POST['is_paused'];
		$sql = " UPDATE pcs_plan SET is_paused = '".$is_paused."',last_update_DB = NOW() WHERE IRCS_Line = '".$registlinename."' AND Status = 'Pending' ";
		if($db->execQuery($sql)){
			echo 'true';
		}
	}
}