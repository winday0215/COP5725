<?php
session_start();
//test link please use "http://127.0.0.1/~Qin/COP5725/restaurant/review.php?RID=1&NAME=Szechuan%20Palace&USER=1"
	$rid = $_POST['rid'];  //restaurant id
	$rname = $_POST['rname']; //restaurant name
	$userid = $_SESSION['user']; //user id
	$rating = $_POST['Rating']; //rating
	$review = $_POST['review']; //review content

	
//database operation
$connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
                          
//insert reviews
$statement = oci_parse($connection, 'SELECT max(reviewid) as reviewid FROM review');
oci_define_by_name($statement, 'REVIEWID', $reviewid);
oci_execute($statement);

if(oci_fetch($statement)){
	$reviewid++;
}
echo $reviewid;

date_default_timezone_set('America/New_York');
$date = date('d-M-y');
//echo $date;

$sql = "INSERT INTO review values ('$reviewid', '$userid', '$rid', '$review', '$date')";
echo $sql;

$statement = oci_parse($connection, $sql);
oci_execute($statement);

//insert ratings
$statement = oci_parse($connection, 'SELECT max(ratingid) as ratingid FROM rates');
oci_define_by_name($statement, 'RATINGID', $ratingid);
oci_execute($statement);

if(oci_fetch($statement)){
	$ratingid++;
}
$sql = "INSERT INTO rates values ('$ratingid', '$rid', '$userid', '$rating')";
//echo $sql;
$statement = oci_parse($connection, $sql);
oci_execute($statement);

header("Location:restaurant.php?RID=$rid");


//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);

?>