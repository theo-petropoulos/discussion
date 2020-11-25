<?php
	session_start();
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');

	if(isset($_POST['disconnect']) && $_POST['disconnect']){
		session_destroy();
		header("Refresh:0");
	}
?>

<!DOCTYPE html>

<html>

	<head>
		<title>Fil de discussion</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="module.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<?php

			if(isset($_SESSION['user']) && $_SESSION['user']){
				if(isset($_POST) && $_POST){
					$message=$_POST['message'];
					$login=$_SESSION['user']['login'];
					$id=mysqli_fetch_assoc($connect->query("SELECT `id` FROM `utilisateurs` WHERE `login`='$login'"));
					$mess_input=$connect->prepare('INSERT INTO `messages` (message, id_utilisateur, `date`) VALUES (?,?, DATE(NOW()) )');
					$mess_input->bind_param("si", $message, $id['id']);
					$mess_input->execute();
				}

				$mess_list=$connect->query('SELECT * FROM `messages` ORDER BY `id`');
				for($i=0;$i<mysqli_num_rows($mess_list);$i++){
					$mess=mysqli_fetch_assoc($mess_list);
					$user=mysqli_fetch_assoc($connect->query("SELECT login FROM utilisateurs WHERE id=$mess[id_utilisateur]"));
					echo $mess['message'] . " - Posté le " . $mess['date'] . " par " . $user['login'] . "<br>";
				}

				?>
				<form method="post" action="discussion.php">
					<label for="message">Entrez votre message :</label>
					<input type="text" id="message" name="message" required>
					<input type="submit" value="Envoyer">
				</form>

				<div id="back2index"><p>Retour à l' <a href="index.php">Accueil</a></p></div>
				<form method="post" action="index.php">
					<input type="checkbox" hidden checked name="disconnect" id="disconnect">
					<input type="submit" id="disconnect_button" value="Déconnecter">
				</form>

				<?php
				mysqli_free_result($mess_list);
			}

			else{
				echo "Vous devez être connecté pour accéder à cette page.<br>";?><p>Retour à l' <a href="index.php">Accueil</a>.</p><?php
			}
			$connect->close();
		?>
	</body>

</html>