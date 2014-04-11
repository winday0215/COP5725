<?php
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
	if (!empty($_POST['submit1'])){
		echo "hi";
		$valid = true;
		//If email is userid we can do accordingly
		$id = $_POST['email'];/*********what I post here is not email, but username**********/
		$password = $_POST['password'];
		
		/**************************
		
		i want user in session as userid in useraccount database, not email. Because
		other tables use userid, not email. can you modify this?
		
		I'm not able to get what you want. 'user' is the name of the session. Here we are logging in using emailid, right? Please feel free to edit as you deem necessary. Do tell in detail if you want us to change as we can't understand this. It is just for logging in. Session is still user.
		
		***************************/
		
		$_SESSION['user']=$id;
		
		if(empty($id) || empty($pass)){ $valid = false; }
		
		if($valid == true)
		{	
			$sql = "select EMAIL from useraccount where EMAIL = '{$id}' AND PASSWORD = '{$password}'";
			$query = oci_parse($connection,$sql);
			oci_execute($query);
			
			//$query = mysql_query($sql); was the SQL syntax
			
			if(oci_num_rows($query) > 0)
			{
			$login='Welcome back ';
			}	
			else
			{
				$login= 'Wrong login or password';
			}

			if(!$query)
			{
				echo $login;
				// setcookie("user",$id, time()+3600);
				//header("Location: index.php");
			}		
			else
			{	
				echo $login;
				setcookie("user",$id, time()+3600);
				echo "<script type='text/javascript'>alert('Successfully logged in!!!')</script>";
				//After signin user sees new index.html page as he is logged in, so sees logout and Logged In: UserName
				
				
				/**************************
		
		here, we need to redirect to index.php
		
		Done that but please read above comment
		
		***************************/
				header("Location: index.php");
			}
			oci_free_statement($query);
		}	
		else
		{ 
			//If did not submit, return to original index.html without signin
			header("Location: index.php");     
			exit;
		}
	}
}	

oci_close($connection);
?>