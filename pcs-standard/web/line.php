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
		padding-left: 380px;
	}

	.section-C{
		padding-top: 30px;
	}
	/*.takta{
		display: inline-block; 
		width: 200px;
	}*/
</style>
</head>
<body>

<div class="pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 offset-1">
				<div class="card bar mb-4">
					<div class="card-body">
						<input type="hidden" id="registlinename" value="<?php echo $registlinename; ?>">
						<input type="hidden" id="started" value="<?php echo $started; ?>">
						<input type="hidden" id="takt" value="<?php echo $takt; ?>">
						<input type="hidden" id="last_takt" value="<?php echo $last_takt; ?>">
						<input type="hidden" id="added_takt_plan" value="<?php echo $added_takt_plan; ?>">
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

							<div class="row plan justify-content-center takt-time section-A">
								<div class="col-lg-8">
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 text-right a">
												<div for="taktv" class="takt-label text-danger">TAKT TIME: </div>
											</div>
											<div class="col-lg-3 text-center mb-2 b">
												<?php
													if($takt == 0){
														echo '<input type="text" readonly class="form-control-plaintext text-danger takt-value" id="taktv" value="N/A">';
													}else{
														echo '<input type="text" readonly class="form-control-plaintext text-danger takt-value" id="taktv" value="00:00:00">';
													}
												?>
											</div>
											<div class="col-lg-4 mt-2 text-left c">
												<div id="taktset" style="font-size: 30px;" >(00:00:00)</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row justify-content-center text-center section-B">
								<div class="col-lg-12">
									<table>
										<tbody>
											<tr>
												<td class="text-right font-weight-bold">PLAN: </td>
												<td>
													<input type="text" readonly class="form-control-plaintext plan-value ml-4 fz-35" id="taktv">
												</td>
											</tr>
											<tr>
												<td class="text-right font-weight-bold">ACTUAL: </td>
												<td>
													<input type="text" readonly class="form-control-plaintext actual-value ml-4 fz-35" id="taktv">
												</td>
											</tr>
											<tr>
												<td class="text-right font-weight-bold">REMAINING: </td>
												<td>
													<input type="text" readonly class="form-control-plaintext remaining-value ml-4 fz-35" id="taktv">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="row justify-content-center text-center section-C">
								<div class="col-lg-12">
									<div class="form-group">
									    <button class="btn btn-lg btn-danger btn-pause mb-4"><i class="fa fa-pause"></i> PAUSE</button>
									    <button class="btn btn-lg btn-info btn-resume mb-4 d-none"><i class="fa fa-play"></i> RESUME</button>
									    <br>
									    <button class="btn btn-lg btn-success btn-target">END TARGET</button>
									    <br>
									    <a href="index.php" class="btn btn-lg btn-secondary btn-menu">MAIN MENU</a>
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
		var interval = 13;
		var barWidth = $('.bar').innerWidth() - 12;
		var processing = $('#processing').val();
		var timerTakt = $("#last_takt").val();
		var timerOn = true;
		var isPause = false;

		getDT();

		$('.done').addClass('d-none');
		$('.running').removeClass('d-none');

		if($('#takt').val() == 0){
			$('.btn-resume').addClass('d-none');
			$('.btn-pause').addClass('d-none');
		}

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
				var last_takt = $("#last_takt").val();
				var added_takt_plan = $("#added_takt_plan").val();
				$.post('src/request.php',{
					request: 'getPlanLine',
					registlinename: registlinename,
					last_takt: last_takt
				}, function(response){
					console.log(response);

					if ($('.plan-value').val() != response.plan){
						$('.plan-value').addClass('reloadedLine');
					}

					if ($('.actual-value').val() != response.actual){
						$('.actual-value').addClass('reloadedLine');
					}

					if ($('.remaining-value').val() != response.remaining){
						$('.remaining-value').addClass('reloadedLine');
					}
					
					// $('.plan-value').val(parseInt(response.plan) + parseInt(added_takt_plan));
					$('.plan-value').val(parseInt(response.plan));
					$('.actual-value').val( parseInt(response.actual));
					$('.remaining-value').val(response.remaining);

					if($('.remaining-value').val() < 0){
						$('.remaining-value').css('color','#dc3545');
					}else if($('.remaining-value').val() > 0){
						$('.remaining-value').css('color','#0066bd');
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
							$('.takt-value').val(takttimer);
							$('#taktset').text('('+taktset+')');
						} else{
							$('.takt-value').val('N/A');
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
			console.log('UPDATE TAKT');
			$.post('src/request.php',{
				request: 'updateTakt',
				registlinename: $('#registlinename').val()
			}, function(response){
				// console.log(response);
				if(response.trim() == "true"){
					// $('.actual-value').val( parseInt( $('.actual-value').val() ) + 1);
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
			$(this).addClass('d-none');
			$('.btn-resume').removeClass('d-none');
			isPause = true;
		});

		$(document).on('click', '.btn-resume', function(e){
			e.preventDefault();
			$(this).addClass('d-none');
			$('.btn-pause').removeClass('d-none');
			isPause = false;
		});


	});
</script>
</body>
</html>