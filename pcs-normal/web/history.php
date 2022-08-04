<?php
	include 'db/config.php';

	$date_start = date('Y').'/'.date('m').'/01';
	$date_end = date('Y').'/'.date('m').'/31';
	if(isset($_GET['date_start'])){
		$date_start = $_GET['date_start'];
		$date_end = $_GET['date_end'];
	}

	if($date_start != ""){
		$q = "
		SELECT *,DATE_FORMAT(SEC_TO_TIME(takt_secs_DB), '%i:%s') AS takt_time FROM pcs_plan
		WHERE datetime_DB 
		BETWEEN '".$date_start." 00:00:00' AND '".$date_end." 23:59:59'
		";
	}else{
		$q = "SELECT *,DATE_FORMAT(SEC_TO_TIME(takt_secs_DB), '%i:%s') AS takt_time FROM pcs_plan";
	}
	$plans = $db->getQuery($q);
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
	
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<div class="card border-primary super-main ">
				<h5 class="card-header">
					<img src="img/icon.png" width="50" height="50" alt="">
					Production Progress Counter
				</h5>
				<div class="card-body">
					
					<div class="col-md-12 pb-4">
						<h2 class="text-center title-header">HISTORY</h2>
					</div>

					<form action="">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Date Range <small class="text-muted">(start <i class="fa fa-arrow-right"></i> end)</small></label>
									<div class="row">
										<div class="col-lg-6">
											<input type="text" name="date_start" class="form-control form-control-sm dt" required value="<?php echo $date_start; ?>">
										</div>
										<div class="col-lg-6">
											<input type="text" name="date_end" class="form-control form-control-sm dt" required value="<?php echo $date_end; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 mt-4 p-2">
								<button type="submit" class="btn btn-sm btn-primary">Search</button>
							</div>
							<div class="col mt-4 p-1 mr-3 text-right">
								<a href="index.php" class="btn btn-secondary">MAIN MENU</a>
							</div>
						</div>
					</form>

					<table class="table table-sm table-bordered">
					  <thead class="thead-dark">
					    <tr>
					      <th>#</th>
					      <th>Line</th>
					      <th>Plan</th>
					      <th>Actual</th>
					      <th>Remaining</th>
					      <th>Status</th>
					      <th>Lot</th>
					      <th>Takt Time <small>(secs)</small></th>
					      <th>Running Date</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php
					    	if($plans){
					    		foreach ($plans as $i => $p) {
					    			$status = "";

					    			if($p['Status'] == "Pending"){
					    				$status = "<span class='badge badge-primary'>Running</span>";
					    			}else{
					    				$status = "<span class='badge badge-success'>Completed</span>";
					    			}

					    			echo '<tr data-id="'.$p['ID'].'">';
					    			echo '<td>'.($i+1).'</td>';
					    			echo '<td>'.$p['Carmodel'].' '.$p['Line'].'</td>';
					    			echo '<td>'.$p['Target'].'</td>';
					    			echo '<td>'.$p['Actual_Target'].'</td>';
					    			echo '<td>'.$p['Remaining_Target'].'</td>';
					    			echo '<td>'.$status.'</td>';
					    			echo '<td><a href="javascript:void(0)" class="tr-click">view</a></td>';
					    			echo '<td>'.$p['takt_time'].'</td>';
					    			echo '<td>'.date('Y/m/d h:i A',strtotime($p['datetime_DB'])).'</td>';
					    			echo '</tr>';
					    		}
					    	}
					    ?>
					  </tbody>
					</table>


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
		$(document).on('click', '.tr-click', function(){
			var id = $(this).closest('tr').data('id');
			var top = 200;
			var left = 427;
			console.log(top, left);
			window.open('lot.php?id='+id, 'pcs', 'resizable=0, scrollbars=yes, width=600, height=200, top=' + top + ', left=' + left);
		});
	});
</script>
</body>
</html>