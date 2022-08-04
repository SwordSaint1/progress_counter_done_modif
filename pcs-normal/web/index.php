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
					
					<div class="col-md-12 pb-4">
						<h2 class="text-center title-header">MAIN MENU (VIEWER)</h2>
					</div>
					<div class="row">

						<div class="col-md-6">
							<a href="main.php">
								<div class="card main-2">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-television fa-4x"></i>
											<p>All Car Maker Monitoring</p>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-6">
							<a href="history.php">
								<div class="card main-5">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-table fa-4x"></i>
											<p>History Logs</p>
										</div>
									</div>
								</div>
							</a>
						</div>
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
		$(document).on('click', 'a.monitor', function(e){
			e.preventDefault();
			var href = $(this).prop('href');
			if (localStorage.getItem("registlinename") === null) {
				window.open(href,"_self");
			}else{
			  	var registlinename = localStorage.getItem("registlinename");
				window.open("line.php?registlinename="+registlinename,"_self");
			}
		});

		$(document).on('click', 'a.plan', function(e){
			e.preventDefault();
			var href = $(this).prop('href');
			if (localStorage.getItem("registlinename") === null) {
				window.open(href,"_self");
			}else{
			  	var registlinename = localStorage.getItem("registlinename");
				window.open("plan.php?registlinename="+registlinename,"_self");
			}
		});
	});
</script>
</body>
</html>