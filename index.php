<?php
	session_start();
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');

	if(isset($_POST['disconnect']) && $_POST['disconnect']){
		session_destroy();
		header("Refresh:0");
	}
?>

<!DOCTYPE html>

<html lang="fr">
	<head>
		<title>Profil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="module.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body id="body_index">
		<?php
			if(isset($_SESSION['user']) && $_SESSION['user']){
				?>
				<main id="main_index">
					<p>Super site qui sert à rien.<br></p>
				</main>
				<form method="post" action="index.php">
					<input type="checkbox" hidden checked name="disconnect" id="disconnect">
					<input type="submit" id="disconnect_button" value="Déconnecter">
				</form>
				<?php
			}


			else{
				?>
				<section id="index_nologin">
					<p>Connectes-toi le fonbou<br></p>
					<a href="inscription.php">Inscription</a><br>
					<a href="connexion.php">Connexion</a><br>
				</section>
				<?php
			}
	
		$connect->close();
	?>
	</body>
</html>