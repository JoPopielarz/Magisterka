<!DOCTYPE html> 
<?php
	//włączenie raportowania błędów
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>
<html lang="pl-PL">
	<?php
		//Dołączenie tekstów w danym języku
		$lang = "pl";
		include "Languages/pl/txt.php"
	?>
	<head>
		<title><?php echo $txtTytulAplikacji?></title>
		<meta charset="UTF-8"> 
    
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="CSS/style.css">	
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>

<body>