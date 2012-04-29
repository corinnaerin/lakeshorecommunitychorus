<!DOCTYPE html>
<html>
<head>
	<title>Lakeshore Community Chorus</title>
	<?php 
	    include ("_partials/head.php");
	    require ("plogger/plogger.php");
		the_plogger_head(); 
	?>
</head>
<body>
<?php include ("_partials/header.php"); ?>
<section>
<?php 
	the_plogger_gallery(); 
?>
</section>
<?php include ("_partials/footer.php"); ?>
</body>
</html>