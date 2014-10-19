<?php
	session_start();
	unset($_SESSION['user']);
	unset($_SESSION['fname']);
	header("Location:index.php");
?>