<?php
	include 'db/config.andon.php';
	include 'db/config.ora.php';

	$carmakers = array(
		"Daihatsu",
		"Nissan",
		"Toyota",
		"Mazda",
		"Suzuki",
		"Honda",
		"Subaru",
	);

?>

<!DOCTYPE html><html class=''>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
	include 'src/link.php';
?>
<title>PRODUCTION PROGRESS BAR</title>

<style>
	.tr-click{
		cursor: pointer;
	}
</style>
</head>
<body class="top">

<div class="pt-1">
	<div class="header">
		<div class="row">
			<div class="container-fluid">
				<div class="col-lg-12 title">
					<div>
						<span>PRODUCTION PROGRESS BAR</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="container-fluid">
				<div class="col-lg-8 legend">
					<div class="card">
						<div class="card-body">
							<div class="rem">
								<div class="rem-box"></div>
								<div class="rem-label">Remaining/Not Met Target</div>
							</div>
							<div class="diff">
								<div class="diff-box"></div>
								<div class="diff-label">Difference/Met Target</div>
							</div>
							<a href="index.php" class="btn ml-4 btn-lg btn-secondary btn-menu">MAIN MENU</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="container-fluid pt-3">
				<div class="col-lg-4">
					<div class="form-check d-inline">
						<input type="checkbox" class="form-check-input" id="a" checked>
						<label class="form-check-label" for="a">Auto Refresh</label>
					</div>
					<div class="form-check d-inline">
						<input type="checkbox" class="form-check-input" id="b" checked>
						<label class="form-check-label" for="b">Auto Scroll</label>
					</div>
					<div class="form-group d-inline">
					    <select id="car_maker" class="form-control">
					    	<?php 
					    	echo '<option selected value="ALL">ALL</option>';
					    	if($carmakers){
					    		foreach ($carmakers as $cm) {
					    			echo '<option value="'.$cm.'">'.$cm.'</option>';
					    		}
					    	}
					    	?>
					    </select>
					  </div>
				</div>
			</div>
		</div>
	</div>

	<div class="content pt-1">
		<div class="carmaker-cont">
			<?php
				foreach ($carmakers as $i => $cm) {
					if ($i < 4){
			?>
				<div class="carmaker <?php echo $cm; ?>" data-carmaker="<?php echo $cm; ?>">
					<h3>
						<img src="img/<?php echo strtoupper($cm); ?>.png" width="50" height="50">
						<?php echo $cm; ?>
					</h3>
					<table class="table">
						<thead>
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			<?php
					}
				}
			?>
		</div>
		<div class="carmaker-cont">
			<?php
				foreach ($carmakers as $i => $cm) {
					if ($i >= 4){
			?>
				<div class="carmaker <?php echo $cm; ?>" data-carmaker="<?php echo $cm; ?>">
					<h3>
						<img src="img/<?php echo strtoupper($cm); ?>.png" width="50" height="50">
						<?php echo $cm; ?>
					</h3>
					<table class="table">
						<thead>
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			<?php
					}
				}
			?>
		</div>
	</div>
</div><!--container-->

<?php
	include 'src/script.php';
?>

<script>
	$(document).ready(function(){
		
		var timer = 0;
		var reloadInterval = 3;
		var tableCount = $('.carmaker').length;
		var timerLimit = (reloadInterval * tableCount) - 1;
		var reloadTable = 1;
		var nextScroll = 1;
		var offsetScroll = 0;
		var firstRowCount = $('.carmaker-cont:nth-child(1) .carmaker').length;
		var timerScroll = (( offsetScroll + (reloadInterval * firstRowCount) )) * 1000;

		var autoScroll = true;
		var autoRefresh = true;

		$(document).on('click', '#a', function(){
			if($(this).is(':checked')){
				autoRefresh = true;
			}else{
				autoRefresh = false;
			}
		});

		$(document).on('click', '#b', function(){
			if($(this).is(':checked')){
				autoScroll = true;
			}else{
				autoScroll = false;
			}
		});

		$(document).on('change', '#car_maker', function(){
			var cm = $(this).val();
			console.log(cm);
			if(cm == "ALL"){
				$('.carmaker').removeClass('d-none');
				$("#b").prop('checked', false);
				autoScroll = true;
			}else{
				$('.carmaker').addClass('d-none');
				$('.'+cm).removeClass('d-none');
				$("#b").prop('checked', true);
				autoScroll = false;
			}

		});

		$(document).on('click', '.tr-click', function(){
			var id = $(this).data('id');
			var top = 200;
			var left = 427;
			console.log(top, left);
			window.open('lot.php?id='+id, 'pcs', 'resizable=0, scrollbars=yes, width=600, height=200, top=' + top + ', left=' + left);
		});

		setInterval(function(){ //auto scroll

			if(autoScroll){
				if(nextScroll == 2){
					nextScroll = 1;
				}else{
					nextScroll ++;
				}

				if(nextScroll == 1){
					scrollToDiv('body');
				}else{
					scrollToDiv('.carmaker-cont:nth-child('+nextScroll+')');
				}

				var frc = $('.carmaker-cont:nth-child('+nextScroll+') .carmaker').length;
				timerScroll = (( offsetScroll + (reloadInterval * frc) )) * 1000;
			}

		}, timerScroll);

		setInterval(function(){
			// console.log(timer);
			if(autoRefresh){
				reloadFrame();
				if(timer == timerLimit){
					timer = 0;
				}else{
					timer++;
				}
			}
		}, 1000);

		function reloadFrame(){
			if((timer % reloadInterval) == 0){
				var carmaker = $('.carmaker').eq(reloadTable-1).data('carmaker');

				$.post('src/request.php',{
					request: 'getPlan',
					carmaker: carmaker
				}, function(response){
					// console.log(response);
					$('.'+carmaker+'').addClass('reloaded');
					$('.'+carmaker+' table tbody').html(response);
				});


				if(reloadTable == tableCount){
					$('.carmaker').removeClass('reloaded');
					reloadTable = 1;
				}else{
					reloadTable ++;
				}
			}
		}
	});

</script>

</body>
</html>