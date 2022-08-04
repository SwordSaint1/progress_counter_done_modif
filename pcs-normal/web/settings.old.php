<?php
	include 'db/config.php';
	include 'db/config.ora.php';

	$ircs_lines = array();
	$q = " SELECT DISTINCT REGISTLINENAME FROM IRCS.T_PACKINGWK ORDER BY REGISTLINENAME ASC ";
	$stid = oci_parse($conn3, $q);
	oci_execute($stid);
	while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		$ircs_lines[] = $row->REGISTLINENAME;
	}
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
					Production Progress Counter
				</h5>
				<div class="card-body">
					
					<div class="col-lg-12 pb-2">
						<h2 class="text-center title-header">CONFIGURE SETTINGS</h2>
						<form class="pt-4" method="post">
							<div class="container-fluid">
								<h4>LINE NO. </h4>
								<hr>
								<div class="col-md-12 col-lg-12">
									<div class="form-group row">
									    <label for="a" class="col-md-6 col-lg-6 col-form-label">SELECT LINE NO.</label>
									    <div class="col-md-6 col-lg-6">
									      <select name="" id="a" class="form-control">
									      	<option value="">- - -</option>
									      	<?php
									      		if ($ircs_lines) {
									      			foreach ($ircs_lines as $i => $ircs) {
									      				echo '<option>'.$ircs.'</option>';
									      			}
									      		}
									      	?>
									      </select>
									    </div>
									  </div>

									  <div class="form-group row">
									      <label for="b" class="col-md-6 col-lg-6 col-form-label">SELECTED LINE NO.</label>
									      <div class="col-md-6 col-lg-6">
									        <input type="text" readonly class="form-control-plaintext" id="b">
									      </div> 
									    </div>
								</div>

							</div>
						</form>
					</div>

					<div class="row justify-content-center text-center">
						<div class="col-lg-12 pt-3">
							<div class="form-group">
							    <a href="index.php" class="btn btn-lg btn-secondary text-white">CLOSE</a>
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