<?php
$resig =$_GET['registlinename'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
  background-color: lightgreen;
}

	/*@media (max-width: 1920) and (min-width: 1920) { 
  body {
    background-color: lightblue;
    color:red;
  }*/
  
  
  <?php
	
	if($resig=='DAIHATSU_07')
	{
			?>
			
			.bar{
				background-color: lightblue;
				zoom:74%;
			}
			
			<?php
	}
	
  
  ?>
  

</style>
</head>
<body class="bar">

<p>Resize the browser window. When the width of this document is 600 pixels or less, the background-color is "lightblue", otherwise it is "lightgreen".</p>
<p id="reso"></p>
<script type="text/javascript">
	var dipa = "Your screen resolution is: " + screen.width + "x" + screen.height; 
		
		document.getElementById("reso").innerHTML = dipa;
</script>
</body>
</html>
