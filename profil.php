<?php
	session_start();
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');
	$connect->query('SET NAMES utf8');

	if(isset($_POST) && $_POST){
		$pre_login=$_SESSION['user']['login'];
		$login=$_POST['login'];$password=$_POST['password'];
		$stmt=$connect->prepare("UPDATE utilisateurs SET login=?, password=? WHERE login='$pre_login' ");
		$stmt->bind_param("ss", $login, $password);
		$stmt->execute();
		$_SESSION['user']=['login'=>$login, 'password'=>$password];
	}
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Profil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="discussion.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body id="body_profil">
		<?php

		if(isset($_SESSION['user']) && !empty($_SESSION['user']['login'])){
			foreach($_SESSION['user'] as $value){
				$pre[]=$value;
			}
		?>
			<main id="profile_changes">
				<h2>Modifier vos informations</h2>

				<form method="post" action="profil.php">
					<label for="password">Mot de passe :</label>
					<input type="password" id="password" name="password" value= <?php for($i=0;$i<strlen($pre[1]);$i++){echo "*";}?> required>
					<input type="submit" id="submit_button" value="Envoyer">
				</form>
				<div id="back2index"><p>Retour à l'<a href="index.php">Accueil</a></p></div>
			</main>
			
		<?php
		}

		else{
			echo "Vous devez d'abord vous connecter pour accéder à cette page.<br>";?><a href="connexion.php">Connexion</a><?php echo ".";
		}
	$connect->close();
	?>
		
	</body>
</html>