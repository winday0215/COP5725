<?php
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$email = $_POST["email"];
	$confirm = $_POST["confirm"];
	$sql = "SELECT email,lname FROM useraccount where email = '$email'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query,'email',$email1);
	oci_execute($query);
	while ($row=oci_fetch_assoc($query)) {
		$email1=$row['EMAIL'];
		$lname1=$row['LNAME'];
	}
	
	if($confirm=="abc123"){
		echo "<script type='text/javascript'>alert('Please reset your password!!!')</script>";
//<<<<<<< HEAD:restaurant/php/confirm.php
		header("Location: rpass.php?email=".$email);
		//echo "<script type='text/javascript'>window.location.replace('/restaurant/rpass.php');</script>";
//=======
		echo "<script type='text/javascript'>window.location.replace('rpass.php');</script>";
//>>>>>>> 972b326ce4f2e9cb68381c40f13f08331d928bf3:restaurant/confirm.php
	}
	else
	{
		echo "<script type='text/javascript'>alert('Wrong code!!! Sorry try again or signup.')</script>";
		echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
	}
?>