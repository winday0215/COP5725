<?php

//test link please use "http://127.0.0.1/~Qin/COP5725/restaurant/review.php?RID=1&NAME=Szechuan%20Palace&USER=1"
	$rid = $_POST['rid'];  //restaurant id
	$rname = $_POST['rname']; //restaurant name
	$userid = $_POST['userid']; //user id
	$title = $_POST['Title']; //review title
	$rating = $_POST['Rating']; //rating
	$review = $_POST['review']; //review content
	
	echo $rid;
	echo "<br>";
	echo $rname;
	echo "<br>";
	echo $userid;
	echo "<br>";
	echo $title;
	echo "<br>";
	echo $rating;
	echo "<br>";
	echo $review;
	echo "<br>";
	
//database operation
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, 'SELECT * FROM useraccount');
oci_execute($statement);


}


//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);

?>