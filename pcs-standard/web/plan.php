

<?php
	include 'db/config.php';

	$running = false;
	$registlinename = $_GET['registlinename'];
	$sql = " 
		SELECT *
		FROM pcs_plan 
		WHERE IRCS_Line = '".$registlinename."' 
		AND Status = 'Pending'
	";
	$plans = $db->getQuery($sql);
	$sql = "SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
	$line_name = $db->getQueryOne($sql)['line_name'];

	if ($plans) {
		$running = true;
	}

?>

<!DOCTYPE html><html class=''>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
	include 'src/link.php';
?>
<title>Production Progress Counter</title>

</head>
<body class="bg-dark">

<div class="pt-4 container-fluid">
	
	<div class="row justify-content-center">
	
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card border-primary super-main ">
				<h5 class="card-header">
					<img src="img/icon.png" width="50" height="50" alt="">
					Production Progress Counter
				</h5>
				<div class="card-body">
					
					<div class="col-lg-12 pb-2">
						<h2 class="text-center title-header">
							SET YOUR TARGET PLAN
							<br>
							(<?php echo $line_name; ?>)
						</h2>
						<form class="pt-4" method="post" action="src/request.php">
							<input type="hidden" name="request" value="addTarget">
							<input type="hidden" name="registlinename" value="<?php echo $_GET['registlinename']; ?>">
							<div class="container-fluid">
								<h4>TAKT TIME: </h4>
								<hr>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
										    <label for="a">Hour</label>
										    <input type="text" name="hrs" class="form-control" id="a" placeholder="00">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
										    <label for="b">Minutes</label>
										    <input type="text" name="mins" class="form-control" id="b" placeholder="00" autofocus="on">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
										    <label for="c">Seconds</label>
										    <input type="text" name="secs" class="form-control" id="c" placeholder="00">
										</div>
									</div>
								</div>
								<br>
								<h4>STARTING PLAN: </h4>
								<hr>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="d">TARGET PLAN</label>
										    <input type="text" name="plan" class="form-control" id="d" placeholder="00">
										</div>
									</div>

									<?php
										$dd = date('F d, Y');
										$time_range = '';
										$time_start = '';
										$time_end = '';
										$time_range = '';
										$current_time = date('h:i a');
										$startDS = "8:00 am";
										$endDS = "7:59 pm";
										$startNS = "8:00 pm";
										$endNS = "7:59 am";
										$date1 = DateTime::createFromFormat('H:i a', $current_time);
										$date2 = DateTime::createFromFormat('H:i a', $startDS);
										$date3 = DateTime::createFromFormat('H:i a', $endDS);
										$date4 = DateTime::createFromFormat('H:i a', $startNS);
										$date5 = DateTime::createFromFormat('H:i a', $endNS);
										if ($date1 > $date2 && $date1 < $date3)
										{
										   $time_range = '8:00 AM - 7:59 PM';
										   $time_start = '08:00:00';
										   $time_end = '19:59:59';
										} else if ($date1 > $date4 && $date1 < $date5){
										   $time_range = '8:00 PM - 7:59 AM';
										   $time_start = '20:00:00';
										   $time_end = '07:59:59';
										}
									?>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="d">TIME RANGE</label>
										    <input type="text" name="time_range" class="form-control" id="e" readonly value="<?php echo $time_range; ?>">
										</div>
										<input type="hidden" name="time_start" value="<?php echo $time_start; ?>">
										<input type="hidden" name="time_end" value="<?php echo $time_end; ?>">
									</div>
								</div>

								<div class="row justify-content-center text-center">
									<div class="col-lg-12 pt-3">
										<div class="form-group">
											<?php
												if($running){
													echo '<button type="button" class="btn btn-lg btn-danger btn-target">ONGOING PROCESS</button>';
												}else{
													echo '<button type="submit" class="btn btn-lg btn-success btn-target">SET PLAN</button>';
												}
											?>
											<br>
											<a href="index.php" class="mt-2 btn btn-secondary btn-target">MAIN MENU</a>
										</div>
									</div>
								</div>

							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include 'src/script.php';
?>

<script>
	$(document).ready(function(){

	});
</script>
</body>
</html>