<?php
	session_start();
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');

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

	<body>
		<?php

		if(isset($_SESSION['user']) && $_SESSION['user']['login']=='admin'){

			?>
			<main id="admin_profile">
				<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ56BG8HCEbnVDH0VyH3a8yW3Eau7CEwDkJw&usqp=CAU">
				<p class="strong_text">Accéder à la page d'<a href="admin.php">Administration</a>.</p>
			</main>
			<?php
		}


		else if(isset($_SESSION['user']) && !empty($_SESSION['user']['login'])){
			foreach($_SESSION['user'] as $value){
				$pre[]=$value;
			}
		?>
			<main id="profile_changes">
				<h2>Modifier vos informations</h2>

				<form method="post" action="profil.php">
					<label for="login">Login : </label>
					<input type="text" id="login" name="login" value= <?php echo $pre[0]?> required>
					<label for="password">Mot de passe :</label>
					<input type="password" id="password" name="password" value= <?php for($i=0;$i<strlen($pre[1]);$i++){echo "*";}?> required>
					<input type="submit" id="submitbutton" value="Envoyer">
				</form>
			</main>
			<div id="back2index"><p>Retour à l' <a href="index.php">Accueil</a></p></div>
		<?php
		}

		else{
			echo "Vous devez d'abord vous connecter pour accéder à cette page.<br>";?><a href="connexion.php">Connexion</a><?php echo ".";
		}
	$connect->close();
	?>
		
	</body>
</html>