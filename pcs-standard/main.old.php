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
</head>
<body>

<div class="pt-4">
	<div class="header">
		<div class="col-lg-4 legend">
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
					<a href="index.php" class="btn ml-4 btn-sm btn-secondary btn-menu">MAIN MENU</a>
				</div>
			</div>
		</div>
		
		<div class="col-lg-5 title pull-right">
			<div class="pull-right">
				<span>
					PRODUCTION
				</span>
				<span>
					PROGRESS BAR
				</span>
			</div>
		</div>
	</div>

	<div class="content pt-4">
		<div class="">
			
			<?php
				foreach ($carmakers as $i => $cm) { //limit 21
					// $sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$cm."%' ORDER BY line_DB";
					// $lines = $db2->getQuery($sql);
					
			?>
				<div class="carmaker <?php echo $cm; ?>" data-carmaker="<?php echo $cm; ?>">
					<h3><?php echo $cm; ?></h3>
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
							<?php 
							// foreach ($lines as $j => $line) {
							// 	if($j < 21){
							// 		$line_name = trim(str_replace($cm, "", $line['line_DB']));
							// 		echo '<tr>';

							// 		echo '<td>'.$line_name.'</td>';
							// 		echo '<td></td>';
							// 		echo '<td></td>';
							// 		echo '<td></td>';
									
							// 		echo '</tr>';
							// 	}
							// }
							?>
						</tbody>
					</table>
				</div>
			<?php
					
					// if(count($lines) > 21){
					// 	$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$cm."%' ORDER BY line_DB";
					// 	$lines = $db2->getQuery($sql);
			?>
					<!-- <div class="carmaker <?php echo $cm; ?>" data-carmaker="<?php echo $cm; ?>">
						<h3>&nbsp;</h3>
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
								<?php 
									foreach ($lines as $j => $line) {
										if($j >= 21){
											$line_name = trim(str_replace($cm, "", $line['line_DB']));
											echo '<tr>';

											echo '<td>'.$line_name.'</td>';
											echo '<td></td>';
											echo '<td></td>';
											echo '<td></td>';
											
											echo '</tr>';
										}
									}
								?>
							</tbody>
						</table>
					</div> -->
			<?php
					// }
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
		$('.content').scrollLeft(2100);
		
		var timer = 0;
		var reloadInterval = 2;
		var tableCount = $('.carmaker').length;
		var timerLimit = (reloadInterval * tableCount) - 1;
		var reloadTable = 1;
		$('.content').width((tableCount * 335));
		$('.content').animate({scrollLeft: $('.Honda').position().left}, 500);

		

		setInterval(function(){
			console.log(timer);
			reloadFrame();
			if(timer == timerLimit){
				timer = 0;
			}else{
				timer++;
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