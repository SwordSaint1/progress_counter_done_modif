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

	<div class="content container-fluid pt-4">
		<div class="row">
			
			<div class="col-lg-4">
				<div class="row">
					<div class="col-lg-6 carmaker daihatsu">
						<h3>Daihatsu</h3>
						<table class="table">
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</table>
					</div>

					<div class="col-lg-6 carmaker subaru">
						<h3>Subaru</h3>
						<table class="table">
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6 carmaker nissan">
						<h3>Nissan</h3>
						<table class="table">
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</table>
					</div>

					<div class="col-lg-6 carmaker toyota">
						<h3>Toyota</h3>
						<table class="table">
							<tr>
								<th>Line</th>
								<th>Target</th>
								<th>Actual</th>
								<th>Rem.</th>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="col-lg-2 carmaker mazda">
				<h3>Mazda</h3>
				<table class="table">
					<tr>
						<th>Line</th>
						<th>Target</th>
						<th>Actual</th>
						<th>Rem.</th>
					</tr>
				</table>
			</div>

			<div class="col-lg-2 carmaker suzuki">
				<h3>Suzuki</h3>
				<table class="table">
					<tr>
						<th>Line</th>
						<th>Target</th>
						<th>Actual</th>
						<th>Rem.</th>
					</tr>
				</table>
			</div>

			<div class="col-lg-2 carmaker honda">
				<h3>Honda</h3>
				<table class="table">
					<tr>
						<th>Line</th>
						<th>Target</th>
						<th>Actual</th>
						<th>Rem.</th>
					</tr>
				</table>
			</div>

		</div>
	</div>
</div><!--container-->

<?php
	include 'src/script.php';
?>

</body>
</html>