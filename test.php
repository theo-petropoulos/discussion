<?php

	$password='testoaoapp';
	echo $password . "<br>";

	$password=password_hash($password, PASSWORD_DEFAULT);

	echo $password . "<br>";

	echo password_verify('testoaoapp', $password);

?>