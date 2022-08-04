<?php
include 'db/config.php';
include 'db/config.andon.php';

$processing = false;
if(isset($_GET['registlinename'])){
	$registlinename = $_GET['registlinename'];

	$q = " SELECT *,STR_TO_DATE(CONCAT(date_db,' ',time_db), '%m/%d/%Y %h:%i:%s %p') AS Started FROM pcs_plan WHERE IRCS_Line = '".$registlinename."' AND Status = 'Pending' ";
	$res = $db->getQuery($q)[0];
	$started = $res['Started'];
	$takt = $res['takt_time_minutes_DB'];
	// $linename = $res['Carmodel'].' '.$res['Line'];
	$sql = " SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
	$line = $db->getQuery($sql)[0]['line_name'];

	$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$line."%' ";
	$linename = $db2->getQuery($sql)[0]['line_DB'];

	if($res){
		$processing = true;
	}

}

?>

<!DOCTYPE html>
<html class=''>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
	include 'src/link.php';
?>
<title>PRODUCTION PROGRESS BAR</title>
</head>
<body>

<div class="pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 offset-1">
				<div class="card bar">
					<div class="card-body">
						<input type="hidden" id="registlinename" value="<?php echo $registlinename; ?>">
						<input type="hidden" id="started" value="<?php echo $started; ?>">
						<input type="hidden" id="takt" value="<?php echo $takt; ?>">
						<div class="row">
							<div class="col-lg-6 text-left">
								<div class="line"><?php echo $linename; ?></div>
								<div class="line done text-success d-none">DONE</div>
								<div class="line running text-danger d-none">RUNNING</div>
							</div>
							<?php
								$dd = date('F d, Y');
								$shift = '';
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
								   $shift = 'Dayshift';
								} else if ($date1 > $date4 && $date1 < $date5){
								   $shift = 'Nightshift';
								}
							?>
							<div class="col-lg-6 text-right">
								<div class="line"><?php echo '('.$shift.')'; ?></div>
								<div class="datenow"></div>
							</div>
						</div>

						<form class="details pt-4">
						<?php
							if($processing){
						?>

							<input type="hidden" id="processing" value="1">

							<div class="form-group row plan justify-content-center takt-time">
								<label for="taktv" class="col-lg-4 col-form-label takt-label text-right text-danger">TAKT TIME: </label>
								<div class="col-lg-4">
									<?php
										if($takt == 0){
											echo '<input type="text" readonly class="form-control-plaintext text-danger takt-value" id="taktv" value="N/A">';
										}else{
											echo '<input type="text" readonly class="form-control-plaintext text-danger takt-value" id="taktv" value="00:00:00">';
										}
									?>
								</div>
							</div>

							<div class="form-group row plan justify-content-center font-weight-bold">
								<label for="plan" class="col-lg-4 col-form-label plan-label text-right">PLAN: </label>
								<div class="col-lg-4">
									<input type="text" readonly class="form-control-plaintext plan-value" id="plan">
								</div>
							</div>

							<div class="form-group row actual justify-content-center font-weight-bold">
								<label for="actual" class="col-lg-4 col-form-label actual-label text-right">ACTUAL: </label>
								<div class="col-lg-4">
									<input type="text" readonly class="form-control-plaintext actual-value" id="actual">
								</div>
							</div>

							<div class="form-group row remaining justify-content-center font-weight-bold">
								<label for="remaining" class="col-lg-4 col-form-label remaining-label text-right">REMAINING: </label>
								<div class="col-lg-4">
									<input type="text" readonly class="form-control-plaintext remaining-value" id="remaining">
								</div>
							</div>

							<div class="row justify-content-center text-center">
								<div class="col-lg-12">
									<div class="form-group">
									    <button class="btn btn-lg btn-success btn-target">END TARGET</button>
									    <a href="plan.php?registlinename=<?php echo $registlinename; ?>" class="btn btn-lg btn-primary btn-set d-none">SET NEW TARGET</a>
									</div>
								</div>
							</div>

						<?php
							}else{
						?>
							<input type="hidden" id="processing" value="0">
							<h1 class="text-danger text-center">Not Running</h1>

							<div class="row justify-content-center text-center">
								<div class="col-lg-12 pt-3">
									<div class="form-group">
									    <a href="index.php" class="btn btn-lg btn-secondary text-white btn-close">MAIN MENU</a>
									</div>
								</div>
							</div>
						<?php
							}
						?>
						</form>

						
					</div>

					<div class="loading"></div>
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

		var timer = 4000;
		var interval = 10;
		var barWidth = $('.bar').innerWidth() - 12;
		var processing = $('#processing').val();
		var timerTakt = 0;
		var timerOn = true;

		getDT();

		$('.done').addClass('d-none');
		$('.running').removeClass('d-none');

		if(processing == 1){
			getValues();
			setInterval(function(){
				if (timerOn == true){
					var loadingWidth = $('.loading').width();
					if (loadingWidth >= (barWidth - 200)){
						$('.plan-value').removeClass('reloadedLine');
						$('.actual-value').removeClass('reloadedLine');
						$('.remaining-value').removeClass('reloadedLine');
					}

					if (loadingWidth <= barWidth){
						$('.loading').css('width',(loadingWidth+7) + 'px');
					}else{
						$('.loading').css('width','0px');
						getValues();
					}
				}
			}, interval);

			function getValues() {
				var registlinename = $("#registlinename").val();
				$.post('src/request.php',{
					request: 'getPlanLine',
					registlinename: registlinename
				}, function(response){
					console.log(response);

					// var dt = moment().format('YYYY/MM/DD HH:mm:ss');
					// var plus = getTakt(response.started,dt,response.takt);

					if ($('.plan-value').val() != response.plan){
						$('.plan-value').addClass('reloadedLine');
					}

					if ($('.actual-value').val() != response.actual){
						$('.actual-value').addClass('reloadedLine');
					}

					if ($('.remaining-value').val() != response.remaining){
						$('.remaining-value').addClass('reloadedLine');
					}
					
					$('.plan-value').val(response.plan);
					// $('.actual-value').val( parseInt(response.actual) + parseInt(plus));
					$('.actual-value').val( parseInt(response.actual));
					$('.remaining-value').val(response.remaining);


				});
			}

			setInterval(function(){
				if (timerOn == true){

					var takttimer = moment.utc(timerTakt*1000).format('HH:mm:ss');
					var takt = $('#takt').val();
					if(takt != 0){
						$('.takt-value').val(takttimer);
					} else{
						$('.takt-value').val('N/A');
					}
					timerTakt++;

					if(takt != 0){
						if(timerTakt > takt){
							//update takt time
							timerTakt = 0;
							updateTakt();
						}
					}
				}

			},1000);

		}else{
			$('.loading').css({
				'width':'100%',
			});
		}

		setInterval(function(){
			getDT();
		}, 1000);

		function getDT(){
			var datenow = moment().format('YYYY/MM/DD hh:mm:ss A');
			$('.datenow').text(datenow);
		}


		function getTakt(started, now, takt) {
		    var startTime = moment(started);
		    var endTime = moment(now);

		    var takt_secs = takt;
		    var duration = moment.duration(endTime.diff(startTime));
		    var hours = duration.hours();
		    var minutes = duration.minutes();
		    var seconds = duration.seconds();
		    var total_secs = ((hours * 60) * 60) + (minutes * 60) + seconds;
		    var plus_target = Math.floor(total_secs / takt_secs);
		    // console.log(plus_target);
		    return plus_target;
		}

		function updateTakt(){
			console.log('UPDATE TAKT');
			$.post('src/request.php',{
				request: 'updateTakt',
				registlinename: $('#registlinename').val(),
			}, function(response){
				console.log(response);
				if(response.trim() == "true"){
					// $('.actual-value').val( parseInt( $('.actual-value').val() ) + 1);
					getValues();
				}
			});
		}

		$(document).on('click', '.btn-target', function(e){
			e.preventDefault();

			var registlinename = $("#registlinename").val();
			$.post('src/request.php',{
				request: 'endTarget',
				registlinename: registlinename
			}, function(response){
				console.log(response);

				if(response.trim() == 'true'){
					timerOn = false;
					$('.btn-set').removeClass('d-none');
					$('.btn-target').addClass('d-none');
					$('.loading').css('width',(barWidth+12) + 'px');
					$('.running').addClass('d-none');
					$('.done').removeClass('d-none');
				}
			});
		});



	});
</script>
</body>
</html>