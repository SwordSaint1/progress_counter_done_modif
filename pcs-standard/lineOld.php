<?php
include 'db/config.php';
include 'db/config.andon.php';

$processing = false;
if(isset($_GET['registlinename'])){
	$registlinename = $_GET['registlinename'];

	$q = " SELECT * FROM pcs_plan WHERE IRCS_Line = '".$registlinename."' AND Status = 'Pending' ";
	$res = $db->getQuery($q)[0];
	$started = $res['actual_start_DB'];
	$takt = $res['takt_secs_DB'];
	$last_takt = $res['last_takt_DB'];
	$last_update_DB = $res['last_update_DB'];
	$is_paused = $res['is_paused'];
	$theme = $res['theme'];

	$sql = " SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
	$line = $db->getQuery($sql)[0]['line_name'];

	$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$line."%' ";
	$linename = $db2->getQuery($sql)[0]['line_DB'];

	if($res){
		$processing = true;
	}

	$secs_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($last_update_DB);
	if($takt > 0){
		$added_takt_plan = floor($secs_diff / $takt);
	}else{
		$added_takt_plan = 0;
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

<style>
	.bar{
		height: 830px;
		margin-bottom: 60px;
	}
	.section-A{
		padding-left: 45px;
	}

	.section-A .b{
		flex: none;
		width: 200px !important;
	}

	.section-B{
		padding-top: 20px;
	}
	.section-B tbody td{
		font-size: 80px;
	}

	.section-C{
		/*padding-top: 30px;*/
	}

	.vals{
		font-size: 400px;
		border: solid 2px #FFF;
		color: #ffffff;
		text-align: center;
		font-family: 'digital-7';

	}


	.labs{
		font-size: 70px;
		color: #ffffff;
		font-weight: bold;
	}

	.btns{
		font-size: 20px;
	}

	.bar{
		background-color: #000;
	}
	.loading {
		visibility:hidden;
	}

	body {
		overflow: hidden;
	}

	<?php
		if($theme == 'DARK'){
	?>
		.bar{
			background-color: #000;
		}
		.labs{
			color: #fff;
		}
		.vals{
			font-family: 'lcd';
			font-size: 400px;
			color: #fff;
		}
		.datenow, .takt-label{
			color: #e9ff36;
		}
	<?php
		}
	?>

</style>
</head>
<body class="bar">

<div class="pt-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card mb-4" style="background-color: transparent;">
					<div class="card-body">
						<input type="hidden" id="registlinename" value="<?php echo $registlinename; ?>">
						<input type="hidden" id="started" value="<?php echo $started; ?>">
						<input type="hidden" id="takt" value="<?php echo $takt; ?>">
						<input type="hidden" id="last_takt" value="<?php echo $last_takt; ?>">
						<input type="hidden" id="added_takt_plan" value="<?php echo $added_takt_plan; ?>">
						<input type="hidden" id="is_paused" value="<?php echo $is_paused; ?>">
						<div class="row">
							<div class="col-lg-6 text-left">
								<div class="line text-success"><?php echo $linename; ?></div>
								<div class="line done text-success d-none">DONE</div>
								<div class="line running text-danger d-none">RUNNING</div>
								<div class="datenow"></div>
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
								<div class="line text-success"><?php echo '('.$shift.')'; ?></div>
								<div class="takt-label" style="font-size: 20px;color: #ffffff;">TAKT TIME: <b class="takt-value">00:00:00</b> <span id="taktset" class="text-danger">(00:00:00)</span></div>
							</div>
						</div>

						<form class="details pt-4">
						<?php
							if($processing){
						?>

							<input type="hidden" id="processing" value="1">

							<div class="row justify-content-start">
								<div class="col-lg-12 section-B">
									<div class="row">
										<div class="col-lg-4 text-center text-right labs">PLAN</div>
										<div class="col-lg-4 text-center text-right labs">ACTUAL</div>
										<div class="col-lg-4 text-center text-right labs">DIFFERENCE</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 plan-value vals" style="margin-top: -100px;">0</div>
										
										<div class="col-lg-4 actual-value vals" style="margin-top: -100px;">0</div>
								
										<div class="col-lg-4 remaining-value vals" style="margin-top: -100px;">0</div>
									</div>
										
									
								</div>
							</div>
							<br><br>

							<!-- this -->

							<div class="row justify-content-center">
								<div class="text-center section-C col-lg-5">

									<div class="row justify-content-center">

										<div class="col-lg-3 mr-3">
											<button class="btn btn-danger btns btn-pause"><i class="fa fa-pause"></i> PAUSE</button>
											<button class="btn btn-info btns btn-resume mr-4 d-none"><i class="fa fa-play"></i> RESUME</button>
										</div>

										<div class="col-lg-3 mr-4 ml-3">
											<button class="btn btn-success btns btn-target">END TARGET</button>
										</div>
										<div class="col-lg-3 mr-4 ml-4">
											<a href="index.php" class="btn btns btn-secondary btn-menu">MAIN MENU</a>
										</div>

									</div>

									<div class="row justify-content-center">
										<div class="col-lg-12 text-center">
											<a href="plan.php?registlinename=<?php echo $registlinename; ?>" class="btn  btn-primary btn-set d-none">SET NEW TARGET</a>
										</div>
									</div>


								</div>

							</div>
						<?php
							}else{
						?>
							<input type="hidden" id="processing" value="0">
							<h1 class="text-danger text-center">Plan not set</h1>

							<div class="row justify-content-center text-center">
								<div class="col-lg-12 pt-3">
									<div class="form-group">
									    <a href="plan.php?registlinename=<?php echo $registlinename; ?>" class="btn btn-lg btn-success text-white btn-close">SET PLAN</a>
									</div>
								</div>
							</div>

							<div class="row justify-content-center text-center"style="background-color: transparent;">
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
		var interval = 13;
		var barWidth = $('.bar').innerWidth() - 12;
		var processing = $('#processing').val();
		var timerTakt = $("#last_takt").val();
		var timerOn = true;
		var isPause = false;

		getDT();

		// $('.done').addClass('d-none');
		// $('.running').removeClass('d-none');

		if($('#takt').val() == 0){
			$('.btn-resume').addClass('d-none');
			$('.btn-pause').addClass('d-none');
		}

		checkPausedStatus();

		function checkPausedStatus(){
			if($("#is_paused").val() == "YES"){
				isPause = true;
				$('.btn-resume').removeClass('d-none');
				$('.btn-pause').addClass('d-none');
				$('.loading').css('background-color','#dc3545');

			}else{
				isPause = false;
				$('.btn-pause').removeClass('d-none');
				$('.btn-resume').addClass('d-none');
				$('.loading').css('background-color','#04e000');
			}

			$(".takt-value").text(moment.utc(timerTakt*1000).format('HH:mm:ss'));
			var takt = $('#takt').val();
			var taktset = moment.utc(takt*1000).format('HH:mm:ss');
			$('#taktset').text('('+taktset+')');
		}

		if(processing == 1){
			getValues();
			setInterval(function(){
				if (timerOn == true && isPause == false){
					var loadingWidth = $('.loading').width();
					if (loadingWidth >= (barWidth - 200)){
						$('.plan-value').removeClass('reloadedLine');
						$('.actual-value').removeClass('reloadedLine');
						$('.remaining-value').removeClass('reloadedLine');
						$('.remaining-value').css('padding-top','0');
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
				var last_takt = $("#last_takt").val();
				var added_takt_plan = $("#added_takt_plan").val();
				$.post('src/request.php',{
					request: 'getPlanLine',
					registlinename: registlinename,
					last_takt: last_takt
				}, function(response){
					console.log(response);

					if ($('.plan-value').text() != response.plan){
						$('.plan-value').addClass('reloadedLine');
						$('.plan-value').css('margin-top','-100px');
							
					}

					if ($('.actual-value').text() != response.actual){
						$('.actual-value').addClass('reloadedLine');
						$('.actual-value').css('margin-top','-100px');
					}

					if ($('.remaining-value').text() != response.remaining){
						$('.remaining-value').addClass('reloadedLine');
						$('.remaining-value').css('margin-top','-100px');
					}
					
					// $('.plan-value').text(parseInt(response.plan) + parseInt(added_takt_plan));
					$('.plan-value').text(parseInt(response.plan));
					$('.actual-value').text( parseInt(response.actual));
					$('.remaining-value').text(response.remaining);

					if($('.remaining-value').text() < 0){
						$('.remaining-value').css('color','#dc3545');
					}else if($('.remaining-value').text() > 0){
						$('.remaining-value').css('color','#6cfc71');
					}else{
						$('.remaining-value').css('color','#212529');
					}

				});
			}

			setInterval(function(){
				if (timerOn == true){
					if(isPause == false){

						var takttimer = moment.utc(timerTakt*1000).format('HH:mm:ss');
						var takt = $('#takt').val();
						var taktset = moment.utc(takt*1000).format('HH:mm:ss');
						$("#last_takt").val(timerTakt);

						if(takt != 0){
							$('.takt-value').text(takttimer);
							$('#taktset').text('('+taktset+')');
						} else{
							$('.takt-value').text('N/A');
							$('#taktset').text('(N/A)');
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
				}

			}, 1000);

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

		function updateTakt(){
			var added_takt_plan = $("#added_takt_plan").val();
			$.post('src/request.php',{
				request: 'updateTakt',
				registlinename: $('#registlinename').val(),
				added_takt_plan: added_takt_plan
			}, function(response){
				if(response.trim() == "true"){
					getValues();
				}
			});
		}

		$(document).on('click', '.btn-target', function(e){
			e.preventDefault();

			$('.btn-resume').addClass('d-none');
			$('.btn-pause').addClass('d-none');

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
					$('.btn-menu').addClass('d-none');
					$('.loading').css('width',(barWidth+12) + 'px');
					$('.running').addClass('d-none');
					$('.done').removeClass('d-none');
				}
			});
		});

		$(document).on('click', '.btn-pause', function(e){
			e.preventDefault();
			var el = $(this);

			$.post('src/request.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'YES'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-resume').removeClass('d-none');
				$('.loading').css('background-color','#dc3545');
				isPause = true;
			});
		});

		$(document).on('click', '.btn-resume', function(e){
			e.preventDefault();
			var el = $(this);

			$.post('src/request.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'NO'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-pause').removeClass('d-none');
				$('.loading').css('background-color','#04e000');
				isPause = false;
			});
		});


	});
</script>
</body>
</html>