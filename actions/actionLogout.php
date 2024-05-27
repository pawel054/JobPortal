<?php
	session_start();
	session_unset();
	
	header('Location: ../user/login.php');
?>