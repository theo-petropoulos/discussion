<?php
	session_start();
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');
	$db=$connect->query('SELECT * FROM utilisateurs');
?>

<!DOCTYPE html>

<html lang="fr">
	<head>
		<title>Inscription</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="module.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<?php
			if(isset($_SESSION['user']) && $_SESSION['user']['login'] && $_SESSION['user']['password']){
				echo "Vous êtes déjà inscrit. Retour à ";?><a href="index.php">l'Accueil</a><?php echo ".";
			}

			else if($_POST){
				?>
				<div id="inscription_if">
					<?php
					$err=0;
					$login=$_POST['login'];$password=$_POST['password'];$cpassword=$_POST['cpassword'];

					if($password!=$cpassword){
						?><section class="mess_connexion"><?php
						echo "Les mots de passe ne correspondent pas. Veuillez ";?><a href="inscription.php">Réessayer</a><?php echo ".";
						$err++;?>
						</section><?php
					}

					for($i=0; $i<mysqli_num_rows($db); $i++){
						$row=mysqli_fetch_assoc($db);

						if($login==$row['login']){?>
							<section class="mess_connexion"><?php
							$err++;
							die("Ce nom d'utilisateur existe déjà.");
							?></section><?php
						}
					}

					if($err==0){
						$stmt=$connect->prepare("INSERT INTO `utilisateurs` (login, password) 
										VALUES (?,? ) ");

						$stmt->bind_param("ss", $login, $password);
						$stmt->execute();
						?><section class="mess_connexion"><?php
						echo "Votre inscription a bien été enregistrée. Retour à ";?><a href="index.php">l'Accueil</a><?php echo ".";
						?></section><?php

						$_SESSION['user']=['login'=>$_POST['login'], 'password'=>$_POST['password']];
					}
					?>
				</div>
			<?php
			}

			else{
		?>
		<section id="form">
			<form method="post" action="inscription.php">
				<label for="login">Entrez votre identifiant : </label>
				<input type="text" id="login" name="login" placeholder="Ex: John-Doe68" required>
				<label for="password">Entrez votre mot de passe : </label>
				<input type="password" id="password" name="password" required>
				<label for="cpassword">Confirmez le mot de passe : </label>
				<input type="password" id="cpassword" name="cpassword" required>
				<input type="submit" id="submitbutton" value="Envoyer">
			</form>
		</section>

		<div id="back2index"><p>Retour à l' <a href="index.php">Accueil</a></p></div>

		<?php
	}

	$connect->close();
	?>


		
	</body>
</html>