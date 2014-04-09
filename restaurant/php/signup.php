<?php

/**************

no session start here,
session only start when sign in
***************/
session_start();

$valid=false;
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if (!isset ($_SESSION['user']))
{
	//echo "abc";
	if (isset ($_POST['submit']))
	{	$valid =true;
		
		$user = $_POST['email'];
        $pass = $_POST['password'];
        $fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$street = $_POST['street'];
		$zip = $_POST['zipcode'];
		$date = $_POST['birthdate'];
		$gen = $_POST['gender'];
		//put default unknown user pic path in image url initially
		$iurl = 'images/pic.jpg';
		$level = 'Gourmet';
		date_default_timezone_set('America/New_York');
		$usersince = date('Y/m/d H:i:s');
		
		/**************

no any session info  when sign up
***************/
		$_SESSION['user']=$user;
		
		if(empty($user) || empty($fname) || empty($lname) ||empty($pass) || empty($city) || empty($state)){ $valid = false; }
		if($valid == true)
		{	
			$sql = "SELECT EMAIL FROM useraccount where EMAIL = '{$user}'";
			$query = oci_parse($connection,$sql);
			oci_execute($query);
			if(oci_num_rows($query) > 0)
			{
				echo "The name is already registered";
			}
			else
			{	
				//take userid as auto increment column so use default
				
				/*************
				query the largest number in userid field at first
				then add 1 as the new userid
				****************/
				$sql = "INSERT into useraccount values(DEFAULT,'$pass','$fname','$lname','$iurl','$street','$zip','$user','$gen','$date','$level','$usersince','$city','$state')";
				$query = oci_parse($connection,$sql);
				oci_execute($query);
							
				if(!$query)
				{
				  echo "Failed ".oci_error();
				}
				else
				{
				  echo "Successful";
				  // setcookie("user",$name, time()+3600);
				  
				  /***************
				  no any session or info  when sign up
				  *******************/
				  session_start();
				  
				  /***************
				  set cookie with userid, userid is unique
				  *******************/
				  setcookie("user",$name, time()+3600);
				  //After signup user sees new index.html page as he is logged in, so sees logout and Logged In: UserName
				  
				  /***************
				  popup an alert window, tell user he has successfully signed up, let him use this info to login, then go to signin.html
				  *******************/
				  header("Location: index1.php");
				}
			}		
		}
	
		else
		{ 
			echo "Enter required fields(Email-ID, Password, First name, Last name, City, State)";			 
		}
	}
}
else
{ 
echo "<meta http-equiv='refresh' content='0;index.php'>";
}
?>