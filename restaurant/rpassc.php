<?php
	
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$email = $_POST["email"];
	$npass = $_POST['newpassword'];
	$cpass = $_POST['vnewpassword'];

	/*
	$sql = "SELECT password FROM useraccount where email = '$email'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'password',$pass);
	oci_execute($query);
	while ($row=oci_fetch_assoc($query)) {
		$pass=$row['PASSWORD'];
	}
	*/

	if ($npass == $cpass)
	{
		$sql = "UPDATE useraccount SET password='$npass' where email='$email'";
		$query = oci_parse($connection,$sql);
		oci_execute($query);
					
		if(!$query)
		{
		  echo "Failed ".oci_error();
		}
		else
		{
		  //setcookie("user",$useridm, time()+3600);
		  echo "<script type='text/javascript'>alert('Password updated successfully!!!!')</script>";
		  echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Passwords do not match!!!')</script>";
		header("Location:rpass.php?email=".$email);
		//echo "<script type='text/javascript'>window.location.replace('/restaurant/password.php');</script>";
	}
	
	oci_free_statement($query);
	oci_close($connection);
	
	/*
	$pass1 = $_POST["newpassword"];
	$pass2 = $_POST["vnewpassword"];
	if($pass1==$pass2)
	{
		echo "<script type='text/javascript'>alert('Password reset successfully!!!')</script>";
		echo "<script type='text/javascript'>window.location.replace('/restaurant/signin.html');</script>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('Passwords do not match, try again!')</script>";
		echo "<script type='text/javascript'>window.location.replace('/restaurant/rpass.php');</script>";
	}*/
?>