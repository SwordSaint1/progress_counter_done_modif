<?php
include 'db/config.php';
include 'db/config.andon.php';

$page = 'line';

if(isset($_GET['list'])){
	$page = $_GET['list'];
}

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

<!DOCTYPE html>
<html class=''>
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<?php
					foreach ($carmakers as $i => $cm) {
						echo '<div class="pb-4 pt-2">';
						echo '<h3>'.$cm.'</h3>';
						echo '<hr>';
						$sql = " SELECT * FROM tblline WHERE line_DB LIKE '%".$cm."%' ORDER BY line_DB";
						$lines = $db2->getQuery($sql);
						foreach ($lines as $j => $line) {
							$line2 = substr($line['line_DB'], -4);

							$sql = "SELECT * FROM pcs_ircs_line WHERE line_name LIKE '%".$line2."%' ";
							$ircs_line = $db->getQuery($sql);
							if($ircs_line){
								echo '<a href="'.$page.'.php?registlinename='.$ircs_line[0]['ircs_line'].'" target="_blank" class="btn btn-lg btn-success rounded-0 m-2">'.$line['line_DB'].'</a>';
							}else{
								echo '<a class="btn btn-lg btn-outline-success rounded-0 m-2 disabled">'.$line['line_DB'].'</a>';
							}
						}
						echo '</div>';
					}
				?>
			</div>
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