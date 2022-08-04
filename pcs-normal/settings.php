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
<style type="text/css">
	@font-face{
		src: url('fonts/Montserrat-Medium.ttf');
		font-family:montserrat;
	}
	body{
		font-family: montserrat;
	}

</style>
<body class="">
<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card " style="background-color: white;border: 1px solid #2a9df4;box-shadow:5px 10px gray;">
				<h5 class="card-header" style="color:#4d6d9a;">
					<img src="img/icon.png" width="50" height="50" alt="" style="border-radius: 30px;">
					Production Progress Counter
				</h5>
				<div class="card-body">
					<div class="col-lg-12 pb-2">
						<h2 class="text-center title-header"  style="color:#86b3d1;">CONFIGURE SETTINGS</h2>
						<form class="pt-4" method="post">
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
											<tr>
												<td class="text-right font-weight-bold fz-25" colspan="2">
													<div class="pl-4">
														<a href="javascript:void(0)" class="btn btn-danger btn-lg btn-clear right">CLEAR <b>[ 1 ]</b></a>
													</div>
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
							    <a href="index.php" class="btn btn-lg btn-secondary text-white" id="mainMenu" style="background-color: #5f6366;">MAIN MENU <b>[ 0 ]</b></a>
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
		$(document).on('click', '.btn-clear', function(){
			localStorage.setItem("registlinename", null);
			window.open("settings.php","_self");
		});
		if (localStorage.getItem("registlinename") === null) {
		  localStorage.setItem("registlinename", null);
		}else{
		  $("#b").val(localStorage.getItem("registlinename"));
		}
		if($("#b").val() != "null"){
			$.post('src/request.php',{
				request: 'getLineName',
				registlinename: $("#b").val()
			}, function(response){
				// console.log(response);
				$("#b").val(response.trim());
			});
		}
		$(document).on('change', '#a', function(){
			localStorage.setItem("registlinename", $("#a").val());
		  	$("#b").val(localStorage.getItem("registlinename"));
		  	location.reload();
		});

		// ADVANCE LISTENER -----------------------------------------------------
		document.addEventListener("keypress",function(e){
			if(e.keyCode == 49 || e.keyCode == 97){
				localStorage.setItem("registlinename", null);
				window.open("settings.php","_self");
			}
			if(e.keyCode == 48 || e.keyCode == 96){
				var url	= $('#mainMenu').prop('href');
				window.open(url,"_self");
			}
		});

	});
</script>
</body>
</html>