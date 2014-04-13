<?php

$valid=false;
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
//else { echo "Successful connection";}

$valid =true;

$user = $_POST['email1'];
$user1 = $_POST['email2'];
$pass = $_POST['password1'];
$pass1 = $_POST['password2'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$city = $_POST['city'];
$state = $_POST['state'];
$street = $_POST['street'];
$zip = $_POST['zipcode'];
$date = $_POST['DOB'];
$gen = $_POST['gender'];
//put default unknown user pic path in image url initially
$iurl = 'images/pic.jpg';
$level = 'Gourmet';
date_default_timezone_set('America/New_York');
$usersince = date('d-M-y');
//echo $pass ." ". $fname ." ". $lname ." ". $iurl ." ". $street ." ". $zip ." ". $user ." ". $gen ." ". $date ." ". $level ." ". $usersince ." ". $city ." ". $state;
if(empty($user) || empty($fname) || empty($lname) ||empty($pass) || empty($city) || empty($state)){ echo "<script type='text/javascript'>alert('Enter required fields(Email-ID, Password, First name, Last name, City, State)')</script>";; $valid = false;}
if($user != $user1) {echo "<script type='text/javascript'>alert('Email IDs do not match')</script>"; $valid=false;}
if($pass != $pass1) {echo "<script type='text/javascript'>alert('Passwords do not match')</script>"; $valid=false;}
if($valid == true)
{	
	$sql1 = "SELECT EMAIL, COUNT(*) AS CNT FROM useraccount where EMAIL = '$user' Group By EMAIL";
	$query1 = oci_parse($connection,$sql1);
	oci_define_by_name($query1, 'CNT',$cnt);
	oci_execute($query1);
	
	while ($row=oci_fetch_assoc($query1)) {
			//echo "qwe";
			//echo $cnt;
	}
	
	if(oci_num_rows($query1) > 0)
	{
		echo "<script type='text/javascript'>alert('The name is already registered')</script>";
	}
	else
	{			
		$sql="select MAX(userid) AS useridm from useraccount";
		$query = oci_parse($connection,$sql);
		oci_define_by_name($query, 'USERIDM',$cnt);
		
		oci_execute($query);
		while ($row=oci_fetch_assoc($query)) {
		    $useridm=$row['USERIDM'];
		}
		$useridm=$useridm+1;
		$sql="Insert into useraccount values('$useridm','$pass','$fname','$lname','$iurl','$street','$zip','$user','$gen','$date','$level','$usersince','$city','$state')";

		$query = oci_parse($connection,$sql);
		oci_execute($query);
					
		if(!$query)
		{
		  echo "Failed ".oci_error();
		}
		else
		{
		  //echo "Successful";
	  	  //set cookie with userid, userid is unique
		  //Done, commenting it out for time being
		  //setcookie("user",$useridm, time()+3600);
		  echo "<script type='text/javascript'>alert('You have successfully signed up!!! You may login using your credentials now.')</script>";
		  
		}
		oci_free_statement($query);
	}
	oci_free_statement($query1);
}
echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
oci_close($connection);
?>