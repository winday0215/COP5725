
<?php
	//Use this file to insert updated values into table USERACCOUNT, and then go back to account.php
	
	
	//get POST values from password.php, form updatepassword-form
	
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$uid = $_POST['uid'];
	echo $uid;
	
	$opass = $_POST['oldpassword'];
	$npass = $_POST['newpassword'];
	$cpass = $_POST['vnewpassword'];
	
	$sql = "SELECT pass FROM useraccount where userid = '{$uid}'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'pass',$pass);
	oci_execute($query);

	if ($pass == $opass)
	{
		if ($npass == $cpass)
		{
			$sql = "INSERT into useraccount (password) values('$npass')";
			$query = oci_parse($connection,$sql);
			oci_execute($query);
						
			if(!$query)
			{
			  echo "Failed ".oci_error();
			}
			else
			{
			  echo "Successful";
			  //setcookie("user",$useridm, time()+3600);
			  echo "<script type='text/javascript'>alert('Password updated successfully!!!!')</script>";
			  header("Location: account.php");
			}
		}
		else
		{
			echo "Passwords do not match";
		}
	}
	else
	{
		echo "Wrong password entered";
	}
	
	oci_free_statement($query);
	oci_close($connection);
//
// VERY important to close Oracle Database Connections and free statements!
//
?>