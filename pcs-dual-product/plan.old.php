

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
					Production Progress Counter
				</h5>
				<div class="card-body">
					
					<div class="col-lg-12 pb-2">
						<h2 class="text-center title-header">SET YOUR TARGET PLAN</h2>
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
										    <input type="text" name="hrs" class="form-control" id="a" placeholder="00" autofocus="on">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
										    <label for="b">Minutes</label>
										    <input type="text" name="mins" class="form-control" id="b" placeholder="00">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
										    <label for="c">Seconds</label>
										    <input type="text" name="secs" class="form-control" id="c" placeholder="00">
										</div>
									</div>
								</div>

								<h4>STARTING PLAN: </h4>
								<hr>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="d">TARGET PLAN</label>
										    <input type="text" name="plan" class="form-control" id="d" placeholder="00">
										</div>
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