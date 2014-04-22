<?php
	//Use this file to insert updated values into table USERACCOUNT, and then go back to account.php	
	
	/*Session start, check if user is set in session, if not, go to signin.html*/
	session_start();
	if(!isset($_SESSION['user'])){
		echo "<script type='text/javascript'>alert('You must login at first!')</script>";
			//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
	}
	
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$uid = $_POST['uid'];
	
	$opass = $_POST['oldpassword'];
	$npass = $_POST['newpassword'];
	$cpass = $_POST['vnewpassword'];
	$sql = "SELECT password FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'password',$pass);
	oci_execute($query);
	while ($row=oci_fetch_assoc($query)) {
		$pass=$row['PASSWORD'];
	}

	if ($pass == $opass)
	{
		if ($npass == $cpass)
		{
			$sql = "UPDATE useraccount SET password='$npass' where userid='$uid'";
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
			  echo "<script type='text/javascript'>window.location.replace('account.php');</script>";
			}
		}
		else
		{
			echo "<script type='text/javascript'>alert('Passwords do not match!!!')</script>";
			echo "<script type='text/javascript'>window.location.replace('password.php');</script>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Wrong password entered')</script>";
		echo "<script type='text/javascript'>window.location.replace('password.php');</script>";
	}
	
	oci_free_statement($query);
	oci_close($connection);
?>