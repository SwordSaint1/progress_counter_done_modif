<?php
	include 'db/config.php';
	include 'db/config.andon.php';

	$id = $_GET['id'];
	$q = "SELECT * FROM pcs_plan WHERE ID = '".$id."' ";
	$plan = $db->getQuery($q)[0];
	$lot_no = $plan['lot_no'];
	$line_full = $plan['Carmodel'].' '.$plan['Line'];

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
<body>

<div class="pt-4 container-fluid">
	
	<div class="row justify-content-center">
		<div class="col-lg-12">
			<div class="pb-2"><h4><?php echo $line_full; ?></h4></div>
			<?php
				$lot_no = explode(',', $lot_no);
				if ($lot_no) {
					foreach ($lot_no as $ln) {
						if($ln){
							echo '<a class="btn btn-outline-primary rounded-0 mr-2 mb-2">'.$ln.'</a>';
						}
					}
				}
			?>
		</div>
	</div>
</div>

<?php
	include 'src/script.php';
?>

<script>
	$(document).ready(function(){


	});
</script>
</body>
</html>