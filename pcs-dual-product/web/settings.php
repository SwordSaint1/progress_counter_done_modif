<?php
	include 'db/config.php';
	// include 'db/config.ora.php';

	$ircs_lines = array();
	$q = "SELECT * FROM pcs_ircs_line ORDER BY ircs_line ASC";
	$ircs_lines = $db->getQuery($q);
	
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
						<h2 class="text-center title-header">CONFIGURE SETTINGS</h2>
						<form class="pt-4" method="post">
							<div class="container-fluid">
								<h4>LINE NO. </h4>
								<hr>

								<div class="" style="width: 100%; padding: 0 0 50px 80px; display: block">
									<table>
										<tbody>
											<tr>
												<td class="text-right font-weight-bold fz-25">SELECT LINE NO. </td>
												<td>
													<select name="" id="a" class="form-control ml-4 fz-25" style="width: 250px">
														<option value="">- - -</option>
														<?php
															if ($ircs_lines) {
																foreach ($ircs_lines as $i => $ircs) {
																	echo '<option value='.$ircs['ircs_line'].'>'.$ircs['ircs_line'].' ('.$ircs['line_name'].')</option>';
																}
															}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td class="text-right font-weight-bold fz-25">SELECTED LINE NO. </td>
												<td>
													<input type="text" readonly class="ml-4 fz-25 form-control-plaintext" id="b">
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
						</form>
					</div>

					<div class="row justify-content-center text-center">
						<div class="col-lg-12 pt-3">
							<div class="form-group">
							    <a href="index.php" class="btn btn-lg btn-secondary text-white">MAIN MENU</a>
							</div>
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

		if (localStorage.getItem("registlinename") === null) {
		  localStorage.setItem("registlinename", null);
		}else{
		  $("#b").val(localStorage.getItem("registlinename"));
		}

		$(document).on('change', '#a', function(){
			localStorage.setItem("registlinename", $("#a").val());
		  	$("#b").val(localStorage.getItem("registlinename"));
		});
	});
</script>
</body>
</html>