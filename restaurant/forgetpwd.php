<?php
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$sql = "SELECT email,lname FROM useraccount where email = '$email'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query,'email',$email1);
	oci_execute($query);
	while ($row=oci_fetch_assoc($query)) {
		$email1=$row['EMAIL'];
		$lname1=$row['LNAME'];
	}
	
	if($email==$email1 && $lname==$lname1){
		echo "<script type='text/javascript'>alert('Password reset link sent. Please enter received confirmation code on next page!!!')</script>";
//<<<<<<< HEAD:restaurant/php/forgetpwd.php
		header("Location: confirmation.php?email=".$email."&lastname="."$lname");
		//echo "<script type='text/javascript'>window.location.replace('/restaurant/confirmation.php');</script>";
//=======
		echo "<script type='text/javascript'>window.location.replace('confirmation.php');</script>";
//>>>>>>> 972b326ce4f2e9cb68381c40f13f08331d928bf3:restaurant/forgetpwd.php
	}
	else
	{
		echo "<script type='text/javascript'>alert('Sorry, Email ID does not exist!!! Please try again or signup.')</script>";
		echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
	}
?>