<?php
//session_start();
$valid=true;
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

//If email is userid we can do accordingly
$id = $_POST['username'];/*********what I post here is not email, but username**********/
$password = $_POST['pwd'];
echo $id ." ". $password ."<br>";

/**************************

i want user in session as userid in useraccount database, not email. Because
other tables use userid, not email. can you modify this?

I'm not able to get what you want. 'user' is the name of the session. Here we are logging in using emailid, right? Please feel free to edit as you deem necessary. Do tell in detail if you want us to change as we can't understand this. It is just for logging in. Session is still user.

***************************/

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
	$login='Welcome';
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
	oci_free_statement($query);
}
else
{ 
	echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
}
oci_close($connection);
?>