<?php
	//Use this file to insert updated values into table USERACCOUNT, and then go back to account.php

	/*Session start, check if user is set in session, if not, go to singin.html*/
	session_start();
	if(!isset($_SESSION['user'])){
		echo "<script type='text/javascript'>alert('You must login at first!')</script>";
			//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
	}
	/******************************/
	
	$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

	if (!$connection) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$uid = $_POST['uid'];
	echo $uid;
	
	$sql = "SELECT email FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'email',$email);
	oci_execute($query);
	
	$sql = "SELECT fname FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'fname',$fname);
	oci_execute($query);
	
	$sql = "SELECT lname FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'lname',$lname);
	oci_execute($query);
	
	$sql = "SELECT city FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'city',$city);
	oci_execute($query);
	
	$sql = "SELECT street FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'street',$street);
	oci_execute($query);
	
	$sql = "SELECT zipcode FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'zipcode',$zipcode);
	oci_execute($query);
	
	$sql = "SELECT dob FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'dob',$date);
	oci_execute($query);

	$sql = "SELECT gender FROM useraccount where userid = '$uid'";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'gender',$gender);
	oci_execute($query);
	
	if ($_POST['city']) {$city = $_POST['city'];}
	if ($_POST['state']) {$state = $_POST['state'];}
	if ($_POST['street']) {$street = $_POST['street'];}
	if ($_POST['zipcode']) {$zip = $_POST['zipcode'];}
	if ($_POST['DOB']) {$date = $_POST['DOB'];}
	if ($_POST['gender']) {$gen = $_POST['gender'];}
	
	$sql = "INSERT into useraccount (street,zipcode,gender,dob,city,state) values('$street','$zip','$gen','$date','$city','$state')";
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
	  echo "<script type='text/javascript'>alert('Changes updated!!!!')</script>";
	  header("Location: account.php");
	}

	oci_free_statement($query);
	oci_close($connection);
//
// VERY important to close Oracle Database Connections and free statements!
//
?>