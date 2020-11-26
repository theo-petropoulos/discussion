<?php
	session_start();
	header('Content-type: text/html; charset=UTF-8');
	$connect=mysqli_connect('localhost', 'root', '', 'discussion');
	$connect->query('SET NAMES utf8');

	if(isset($_POST['disconnect']) && $_POST['disconnect']){
		session_destroy();
		header("Refresh:0");
	}
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Fil de discussion</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<meta http-equiv="Content-language" content="fr" />
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Geo&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="discussion.css?v=<?php echo time(); ?>">
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body id="body_discussion">
		<?php

			if(isset($_SESSION['user']) && $_SESSION['user']){
				?>
				<main id="main_discussion">
					<?php
					if(isset($_POST) && $_POST){
						$message=$_POST['message'];
						$login=$_SESSION['user']['login'];
						$id=mysqli_fetch_assoc($connect->query("SELECT `id` FROM `utilisateurs` WHERE `login`='$login'"));
						$mess_input=$connect->prepare('INSERT INTO `messages` (message, id_utilisateur, `date`) VALUES (?,?, NOW() )');
						$mess_input->bind_param("si", $message, $id['id']);
						$mess_input->execute();
						header('Location:discussion.php');
					}
					?>
					<h1>- C'est quoi ce site ? -</h1>
					<?php

					$mess_list=$connect->query('SELECT * FROM `messages` ORDER BY `date`');
					for($i=0;$i<mysqli_num_rows($mess_list);$i++){
						?>
						<div class="message_block"><?php
							$mess=mysqli_fetch_assoc($mess_list);
							$user=mysqli_fetch_assoc($connect->query("SELECT login FROM utilisateurs WHERE id=$mess[id_utilisateur]"));
							echo  $mess['message'];?><span class="message_by"><?php echo "<br>Posté le " . $mess['date'] . " par " . $user['login'] . "<br>";
						?></div><?php
					}

					?>
					<div id="post_message">
						<textarea name="message" id="message" form="submit_mess" rows="3" cols="80" required></textarea>
						<form method="post" action="discussion.php" id="submit_mess">
							<input id="submit_mess_button" type="submit" value="Envoyer">
						</form>
					</div>

					<div id="back2index"><p>Retourner à l' <a href="index.php">Accueil</a></p></div>
					<form method="post" action="index.php">
						<input type="checkbox" hidden checked name="disconnect" id="disconnect">
						<input type="submit" id="disconnect_button" value="Déconnecter">
					</form>

					<?php
					mysqli_free_result($mess_list);
				}

			else{
				?><main id="discussion_nologin">
					<?php
					echo "Vous devez être connecté pour accéder à cette page.<br>";?><p><div id="back2index">Retour à l'<a href="index.php">Accueil</a>.</div></p><?php
			}
			$connect->close();
		?>
	</body>

</html>