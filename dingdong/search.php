<?php

/*
search by city, name, zipcode here
*/
$Searchtype = $_POST['searchtype'];
$SearchPara = $_POST['searchkey'];


if($Searchtype == 'City'){
	header("Location: allrestaurants.php?SearchBy=$Searchtype&SearchPara=$SearchPara");
	exit;
}
if($Searchtype == 'Restaurant Name'){
	header("Location: allrestaurants.php?SearchBy=RestaurantName&SearchPara=$SearchPara");
	exit;
}
if($Searchtype == 'Zipcode'){
	header("Location: allrestaurants.php?SearchBy=$Searchtype&SearchPara=$SearchPara");
	exit;
}
if($Searchtype == 'Cuisine'){
	header("Location: allrestaurants.php?SearchBy=$Searchtype&SearchPara=$SearchPara");
	exit;
}
?>
