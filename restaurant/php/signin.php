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
	if (isset ($_POST['submit'])){
	
		$valid = true;
		//If email is userid we can do accordingly
		$id = $_POST['email'];
		$password = $_POST['password'];
		
		/**************************
		
		i want user in session as userid in useraccount database, not email. Because
		other tables use userid, not email. can you modify this?
		
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
				//After signin user sees new index.html page as he is logged in, so sees logout and Logged In: UserName
				
				
				/**************************
		
		here, we need to redirect to index.php
		
		***************************/
				header("Location: index1.html");
			}
			
		}	
		else
		{ 
			//If did not submit, return to original index.html without signin
			header("Location: index.html");     
			exit;
		}
	}
}	
oci_free_statement($statement);
oci_close($connection);