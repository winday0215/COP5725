<?php
session_start();
$valid=true;
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

//If email is userid we can do accordingly
$id = $_POST['username'];
$password = $_POST['pwd'];
//echo $id ." ". $password ."<br>";



//$_SESSION['user']=$id;

if(empty($id) || empty($password)){ $valid = false; }

if($valid == true)
{	
	$sql = "select EMAIL, COUNT(*) AS CNT from useraccount where EMAIL = '$id' AND PASSWORD = '$password' Group By EMAIL";
	$query = oci_parse($connection,$sql);
	oci_define_by_name($query, 'CNT',$cnt);
	oci_execute($query);
	while ($row=oci_fetch_assoc($query)) {
	}
	
	if(oci_num_rows($query) > 0)
	{
	//get userid and first name from database and set them to session
		$sql1 = "SELECT userid, fname FROM useraccount WHERE email = '$id'";
		$query1 = oci_parse($connection,$sql1);
		oci_define_by_name($query1, 'USERID',$userid);
		oci_define_by_name($query1, 'FNAME',$fname);
		oci_execute($query1);
		while(oci_fetch($query1)){
			$_SESSION['user']=$userid;
			$_SESSION['fname']=$fname;
			//echo $_SESSION['user'];
		}
	//end of session part
		$login="Welcome, $fname";
	}	
	else
	{
		$login= 'Wrong login or password';
	}

	if(!$query)
	{
		echo "<script type='text/javascript'>alert('$login')</script>";
		//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
	}		
	else
	{	
		//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>alert('$login')</script>";
		
		//After signin user sees new index.html page as he is logged in, so sees logout and Logged In: UserName
		echo "<script type='text/javascript'>window.location.replace('index.php');</script>";
	}
	oci_free_statement($query1);
	oci_free_statement($query);
}
else
{ 
	echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
}
oci_close($connection);
?>