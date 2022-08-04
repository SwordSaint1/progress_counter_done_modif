<?php
include 'db/config.php';
// include 'db/config.andon.php';
error_reporting(0);
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
	$lineNo = $res['Line'];
	$sql = " SELECT * FROM pcs_ircs_line WHERE ircs_line = '".$registlinename."' ";
	$line = $db->getQuery($sql)[0]['line_name'];
	$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$line."%' ";
	// $linename = $db2->getQuery($sql)[0]['line_DB'];
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
<title>PRODUCTION PROGRESS COUNTER</title>
<style>
	.bar{
		height: 880px;
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
		font-family: 'lcd';

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
	.base-timer {
  position: relative;
  width: 150px;
  height: 150px;
}

.base-timer__svg {
  transform: scaleX(-1);
}

.base-timer__circle {
  fill: none;
  stroke: none;
}

.base-timer__path-elapsed {
  /*stroke-width: 7px;*/
  /*stroke: grey;*/
}

.base-timer__path-remaining {
  /*stroke-width: 7px;*/
  /*stroke-linecap: round;*/
  transform: rotate(90deg);
  transform-origin: center;
  transition: 1s linear all;
  fill-rule: nonzero;
  /*stroke: currentColor;*/
}

.base-timer__path-remaining.green {
  color: rgb(65, 184, 131);
}

.base-timer__path-remaining.orange {
  color: orange;
}

.base-timer__path-remaining.red {
  color: red;
}

.base-timer__label {
  position: absolute;
  width: 150px;
  height: 150px;
  top: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 100px;
  color: white;
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
<body class="bar" style="zoom: 60%">
	
<!-- CHECKING SCREEN RESOLUTION IF REGISTERED TO FIT SCREEN LIST -->
<?php
// 	include "db/conn.php";
// 	$chck ="SELECT *FROM pcs_resolution_tv WHERE ircs_line_name = '$registlinename'";
// 	$stmt = $conn->prepare($chck);
// 	$stmt->execute();
// 	$stmt->fetchALL();
// 	if($stmt->rowCount() > 0){
// 	echo '<style>.bar{zoom:60%;}</style>';
// }
?> 
<style type="text/css" id="fit_style"></style>
<div class="pt-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card mb-4" style="background-color: transparent;">
					<div class="card-body">
						<input type="hidden" id="registlinename" value="<?php echo $registlinename; ?>">
						<input type="hidden" id="line" value="<?php echo $lineNo; ?>">
						<input type="hidden" id="started" value="<?php echo $started; ?>">
						<input type="hidden" id="takt" value="<?php echo $takt; ?>">
						<input type="hidden" id="last_takt" value="<?php echo $last_takt; ?>">
						<input type="hidden" id="added_takt_plan" value="<?php echo $added_takt_plan; ?>">
						<input type="hidden" id="is_paused" value="<?php echo $is_paused; ?>">
						<div class="row">
							<div class="col-lg-6 text-left">
								<div class="line text-success"><h1 style="font-size: 60px;color:"><b><?php echo $registlinename."(".$lineNo.")"; ?></b></h1></div>
								<div class="line done text-success d-none">DONE</div>
								<div class="line running text-danger d-none">RUNNING</div>
								<!-- <div class="datenow"></div> -->
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
								} else{
								   $shift = 'Nightshift';
								}
							?>
							<div class="col-lg-6 text-right">
								<div class="line text-success"><b><?php echo '('.$shift.')'; ?></b></div>
								<div class="takt-label" style="font-size: 40px;color: #ffffff;">TAKT TIME: <b class="takt-value">00:00:00</b> <span id="taktset" class="text-danger">(00:00:00)</span></div>
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
										<div class="col-lg-4 plan-value vals" style="margin-top: -100px;" id="plan_id">0</div>
										
										<div class="col-lg-4 actual-value vals" style="margin-top: -100px;" id="actual_id">0</div>
								
										<div class="col-lg-4 remaining-value vals" style="margin-top: -100px;" id="difference_id">0</div>
									</div>
										
									
								</div>
							</div>
							<br>
							<div class="row justify-content-center text-center">
									<progress id="progress" style="height: 20px; width: 30%;">
								<!-- <input type="text" name="" id="progress_max"> -->
						</div>
						<div class="row justify-content-center text-center">
						  <div id="app"></div>
						  <!-- count down button for trial  -->
							<!-- <input type="button" onclick="starTimer()" value="Start" />
							<input type="button" onclick="pauseTimer()" value="Pause" />
							<input type="button" onclick="resumeTimer()" value="Resume" />
							<input type="button" onclick="resetTimer()" value="Reset" /> -->
						</div>

							<!-- this -->

							<div class="row justify-content-center">
								<div class="text-center section-C col-lg-5">
									<div class="row justify-content-center">
										<div class="col-lg-3 mr-3">
											<button class="btn btn-danger btns btn-pause"><i class="fa fa-pause"></i> PAUSE <b>[ 1 ]</b></button>
											<button class="btn btn-info btns btn-resume mr-4 d-none"><i class="fa fa-play"></i> RESUME <b>[ 3 ]</b></button>
										</div>
										<div class="col-lg-3 mr-4 ml-3">
											<button class="btn btn-success btns btn-target">END TARGET <b>[ 2 ]</b></button>
										</div>
										<div class="col-lg-3 mr-4 ml-4">
											<a href="index.php" class="btn btns btn-secondary btn-menu">MAIN MENU <b>[ 0 ]</b></a>
										</div>
									</div>
									<div class="row justify-content-center">
										<div class="col-lg-12 text-center">
											<a href="plan.php?registlinename=<?php echo $registlinename; ?>" class="btn  btn-primary btn-set d-none" id="setnewTargetBtn">SET NEW TARGET <b>[ 5 ]</b></a>
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
									    <a href="plan.php?registlinename=<?php echo $registlinename; ?>" class="btn btn-lg btn-success text-white btn-close" id="setplanBtn">SET PLAN <b>[ 4 ]</b></a>
									</div>
								</div>
							</div>

							<div class="row justify-content-center text-center"style="background-color: transparent;">
								<div class="col-lg-12 pt-3">
									<div class="form-group">
									    <a href="index.php" class="btn btn-lg btn-secondary text-white btn-close">MAIN MENU <b>[ 0 ]</b></a>
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
		var interval = 20;
		var barWidth = $('.bar').innerWidth() - 12;
		var processing = $('#processing').val();
		var timerTakt = $("#last_takt").val();
		var timerOn = true;
		var isPause = false;

		getDT();
		setTimeout(startTimer,1000);
		setTimeout(progress_max,1000);
		takt_progress();

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
					// console.log(registlinename);
				$.post('src/request.php',{
					request: 'getPlanLine',
					registlinename: registlinename,
					last_takt: last_takt
				}, function(response){
					fetch_digit();
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
						$('.remaining-value').css('color','#ffffff');
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
								setTimeout(onTimesUp, 1000);
								updateTakt();
								setTimeout(takt_progress, 1000);	
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
			takt_progress();
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
			pauseTimer();
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
			resumeTimer();
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
// ---EVENT LISTENER -----------------------------------------------------------------//
		document.addEventListener("keypress",function(x){
			// PAUSE USING KEY NUMBER 1
			if(x.keyCode == 49 || x.keyCode == 97){
				var el = $(this);
			$.post('src/request.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'YES'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-pause').addClass('d-none');
				$('.btn-resume').removeClass('d-none');
				$('.loading').css('background-color','#dc3545');
				isPause = true;
			});
			}
			// END TARGET USING KEY NUMBER 2 -----------------------------------------------------------------------------
			if(x.keyCode == 50 || x.keyCode == 98){
				var x = confirm('Confirm to end the target?');
				if(x == true){
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
				}else{
					// DO NOTHING
				}
			}
			// RESUME BUTTON
			if(x.keyCode == 51 || x.keyCode == 99){
				var el = $(this);
				$.post('src/request.php',{
					request: 'setPaused',
					registlinename: $("#registlinename").val(),
					is_paused: 'NO'
				}, function(response){
					console.log(response);
					el.addClass('d-none');
					$('.btn-resume').addClass('d-none');
					$('.btn-pause').removeClass('d-none');
					$('.loading').css('background-color','#04e000');
					isPause = false;
				});
				}
			// MAIN MENU
			if(x.keyCode == 48 || x.keyCode == 96){
				window.open('index.php','_self');
			}
			// SET PLAN ------------------------------------------------------------------------------------------------------------
			if(x.keyCode == 52 || x.keyCode == 100){
				var url = $('#setplanBtn').prop('href');
				window.open(url,"_self");
			}
			// SET NEW TARGET
			if(x.keyCode == 53 || x.keyCode == 101){
				var url = $('#setnewTargetBtn').prop('href');
				window.open(url,"_self");
			}
		});

	});
			// TIMER FOR DIGIT LENGTH CHECK
	

		function fetch_digit(){
			var plan_length = $('#plan_id').text().length;
			var actual_length = $('#actual_id').text().length;
			var diff_length = $('#difference_id').text().length;
			console.log(plan_length);
			console.log(actual_length);
			console.log(diff_length);

			if(plan_length >= 3 && actual_length  >= 3 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:50%;}');
			}else if(plan_length >= 3 && actual_length  >= 1 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 3 && actual_length  >= 3 && diff_length >= 1){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >=3 && actual_length >=2 && diff_length >= 2){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 3 && actual_length  >= 2 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 2 && actual_length  >= 2 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:65%;}');
			}
			else{
				$('#fit_style').html('.bar{zoom:65%;}');
			}
		}

		//progress bar

	const takt_progress =()=>{
	
	var taktcount = document.querySelector('.takt-value').innerHTML;
	// console.log(taktcount);
	var array = taktcount.split(":");
	var seconds = (parseInt(array[0], 10) * 60 * 60) + (parseInt(array[1], 10) * 60) + parseInt(array[2], 10)
	var asd = document.getElementById('progress').value = seconds;
	// takts();
		}
	const progress_max =()=>{
				var ircs_line = document.getElementById('registlinename').value;
			var line = document.getElementById('line').value;
			$.ajax({
		url: 'src/progress.php',
		type: 'POST',
		cache: false,
		data:{
			method: 'fetch_progress_max',
			ircs_line:ircs_line,
			line:line
		},success:function(response){
			// console.log(response);
			document.getElementById('progress').max = response;

			
		}
	});
		}



//count down

const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "black"
  },
  warning: {
    color: "black",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "black",
    threshold: ALERT_THRESHOLD
  }
};

let TIME_LIMIT = document.getElementById('takt').value;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

function init() {
  document.getElementById("app").innerHTML = `
  <div class="base-timer">
    <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <g class="base-timer__circle">
        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
        <path
          id="base-timer-path-remaining"
          stroke-dasharray="283"
          class="base-timer__path-remaining ${remainingPathColor}"
          d="
            M 50, 50
            m -45, 0
            a 45,45 0 1,0 90,0
            a 45,45 0 1,0 -90,0
          "
        ></path>
      </g>
    </svg>
    <span id="base-timer-label" class="base-timer__label">${formatTime(
      timeLeft
    )}</span>
  </div>
  `;
}

function onTimesUp() {
  clearInterval(timerInterval);
  resetTimer();
  startTimer();
  
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
      // alert("Time Up");
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const {
    alert,
    warning,
    info
  } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}

function starTimer() {
  startTimer();
}

function pauseTimer() {
  //pause timer
  clearInterval(timerInterval);
}

function resumeTimer() {
  //resume timer
  startTimer();
}

function resetTimer() {
  TIME_LIMIT = document.getElementById('takt').value;
  timePassed = 0;
  timeLeft = TIME_LIMIT;
  init();
}

// On page load
init();

</script>
</body>
</html>