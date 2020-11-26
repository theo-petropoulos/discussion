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
		<title>Accueil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="discussion.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body id="body_index">
		<?php
			if(isset($_SESSION['user']) && $_SESSION['user']){
				?>
				<main id="main_index">
					<form method="post" action="index.php">
						<img src="https://i.imgur.com/jFbqXuC.gif"><br>
						<label for="fakelabel">
							Ce site n'a <span class="strongtext">aucune utilité</span>.<br>Enfin je crois. J'en suis <span class="strongtext">presque sûr</span> même.<br><span class="strongtext">Pourquoi</span> vous êtes-vous inscrit ?<br>Puisque vous êtes-là, vous pouvez toujours aller <a href="discussion.php">discuter</a> avec les autres.<br>Enfin, s'il y a <span class="strongtext">quelqu'un d'autre</span> ?<br>Ce qui me parait <span class="strongtext">hautement improbable</span>.<br>Avez-vous déjà vu le film <span class="strongtext">CUBE</span> ?<br>Enfin.<br>Je vous invite à vous</label>
						<input type="checkbox" hidden checked name="disconnect" id="disconnect">
						<input type="submit" id="disconnect_button" value="Déconnecter">
						<label for="fakelabel2">.<br><br>Vraiment, <span class="strongtext">faites-le</span>.<br><br>Vous pouvez aussi <a href="profil.php">Modifier votre profil</a>.</label>
					</form>
				</main>
				<?php
			}


			else{
				?>
				<main id="main_nologin">
					<div id="index_nologin">
						<p>Il n'est <span class="strongtext">pas avisé</span> de vous <span class="strongtext">inscrire</span>.<br>Si vous êtes inscrit, il n'est <span class="strongtext">pas avisé</span> de vous <span class="strongtext">connecter</span>.<br></p>
						<details>
							<summary>Vous souhaitez vraiment faire <span class="strongtext">comme bon vous semble</span> ?</summary>
							<details>
								<summary><span class="strongtext">Vraiment</span> ?</summary>
									<a href="inscription.php">Inscription</a><br>
									<a href="connexion.php">Connexion</a><br>
								</details>
						</details>
					</div>
				</main>
				<?php
			}
	
		$connect->close();
	?>
	</body>
</html>