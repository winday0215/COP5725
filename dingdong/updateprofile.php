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
	//echo $uid;
	
	$sql = "SELECT * FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'email',$email);
	oci_define_by_name($query, 'fname',$fname);
	oci_define_by_name($query, 'lname',$lname);
	oci_define_by_name($query, 'city',$city1);
	oci_define_by_name($query, 'street',$street1);
	oci_define_by_name($query, 'state',$state1);
	oci_define_by_name($query, 'zipcode',$zipcode1);
	oci_define_by_name($query, 'dob',$date1);
	oci_define_by_name($query, 'gender',$gender1);
	oci_execute($query);

	while ($row=oci_fetch_assoc($query)) {
		$email=$row['EMAIL'];
		$fname=$row['FNAME'];
		$lname=$row['LNAME'];
	}

	if ($_POST['city']) {$city = $_POST['city'];} else {$city = $city1; }
	if ($_POST['state']) {$state = $_POST['state'];} else {$state = $state1;}
	if ($_POST['street']) {$street = $_POST['street'];} else {$street = $street1;}
	if ($_POST['zipcode']) {$zipcode = $_POST['zipcode'];} else {$zipcode = $zipcode1;}
	if ($_POST['DOB']) {$date = $_POST['DOB'];} else {$date = $date1;}
	if ($_POST['gender']) {$gender = $_POST['gender'];} else {$gender = $gender1;}

	//echo $email ." ". $fname ." ". $lname ." ". $street ." ". $state ." ". $zipcode ." ". $gender ." ". $date ." ". $city;

	$sql = "UPDATE useraccount SET street='$street', zipcode='$zipcode', gender='$gender', dob='$date', city='$city', state='$state' WHERE userid='$uid'";
	$query = oci_parse($connection,$sql);
	oci_execute($query);
				
	if(!$query)
	{
	  echo "Failed ".oci_error();
	}
	else
	{
	  echo "<script type='text/javascript'>alert('Changes updated!!!!')</script>";
	  echo "<script type='text/javascript'>window.location.replace('account.php');</script>";
	}

	oci_free_statement($query);
	oci_close($connection);
?>