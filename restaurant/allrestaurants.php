<!DOCTYPE html>
<html lang="en">
<head>
<title>Kravings.com | List All Restaurants</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen">
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Dynalight_400.font.js" type="text/javascript"></script>
<script src="js/FF-cash.js" type="text/javascript"></script>
<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
<script src="js/hover-image.js" type="text/javascript"></script>
<script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="js/jquery.bxSlider.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#slider-2').bxSlider({
        pager: true,
        controls: false,
        moveSlideQty: 1,
        displaySlideQty: 4
    });
    $("a[data-gal^='prettyPhoto']").prettyPhoto({
        theme: 'facebook'
    });
});
</script>
<!--[if lt IE 9]><script type="text/javascript" src="js/html5.js"></script><![endif]-->
</head>
<body id="page3">
<!--==============================header=================================-->
<header>
  <div class="row-top">
    <div class="main">
      <div class="wrapper">
        <h1><a href="index.html">Kravings<span>.com</span></a></h1>
        <nav>
          <ul class="menu">
            <li>      
          		<form action="search.php" method="post"> 
			  		<input type="text" id="tb7" name="searchkey" id="searchkey"/>
			  		<select name="searchtype" id="searchtype">
				  		<option id="">--Search By--</option>
				  		<option id="city">City</option>
				  		<option id="name">Restaurant Name</option>
				  		<option id="zipcode">Zipcode</option>
			  		</select>
			  		<button name="searchbutton" id="searchbutton">Search</button> 
			  	</form>
      		</li>
            <li><a href="index.html">Home</a></li>
            <li><a href="allrestaurants.php">Restaurants</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="signin.html">SignIn/SignUp </a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <div class="row-bot">
    <div class="row-bot-bg">
      <div class="main">
        <h2>Impressive Selection <span>for any Occasion</span></h2>
      </div>
    </div>
  </div>
</header>
<!--==============================content================================-->
<section id="content">
  <div class="main">
    <div class="container">
      <h3 class="prev-indent-bot">Restaurant List</h3>
        <div>
        <?php
        //check if it's a search result
        	$SearchBy = '';
        	$SearchPara = '';
            if(isset($_GET['SearchBy'])){
	         	$SearchBy = $_GET['SearchBy'];
            }
            if(isset($_GET['SearchPara'])){
	         	$SearchPara = $_GET['SearchPara'];
            }
            
            
            $connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
                          
            if($SearchBy == '' && $SearchPara == ''){
            //choose restaurants, calculate average rating and display by averate rating DESC order
            //
			$stid = oci_parse($connection, 
			'SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, avg(ra.rating) as rating
			FROM restaurant r, rates ra 
      WHERE r.rid = ra.rid 
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange 
      order by avg(ra.rating) DESC');
			
			//this define must be done before oci_execute
			oci_define_by_name($stid, 'RID',$rid);
			oci_define_by_name($stid, 'RNAME',$rname);
			oci_define_by_name($stid, 'STREET',$street);
			oci_define_by_name($stid, 'CITY',$city);
			oci_define_by_name($stid, 'STATE',$state);
			oci_define_by_name($stid, 'ZIPCODE',$zipcode);
			oci_define_by_name($stid, 'PRICERANGE',$pricerange);
			oci_define_by_name($stid, 'RATING', $rating);
			oci_execute($stid);
						
			$i =1;
			
			while (oci_fetch($stid)) {
				if($i == 10){
					$i = 1;
				}
				echo "<hr>";
				echo "<ul class='price-list p2>'";
				echo "<li><h5><a href='restaurant.php?RID=$rid'>$rname</a></h5><span><img src='images/$i.jpg' width='80' height='60'></span></li><br>";
				echo "<li>$street, $city, $state, $zipcode</li>";
				echo "<li>Price: ";
				if($pricerange == 1){
					echo "\$";
				}
				else if($pricerange == 2){
					echo "\$\$";
				}
				else if($pricerange == 3){
					echo "\$\$\$";
				}
				else if($pricerange == 4){
					echo "\$\$\$\$";
				}
				else if($pricerange == 5){
					echo "\$\$\$\$\$";
				}
				echo "</li>";
				echo "<li>Rating: ";
				if (ceil($rating) == 5){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 4){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 3){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 2){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 1){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 0){
					echo "No Ratings";
				}
				echo "</li>";
				echo "</ul>";
				$i++;
			}

//
// VERY important to close Oracle Database Connections and free statements!
//
			oci_free_statement($stid);
		}
		
		//display searched restaurant
		else {
			if($SearchBy == 'City'){
				$sql = "SELECT r.rid, r.rname, r.street, r.city, 
				r.state, r.zipcode, r.pricerange, avg(ra.rating) as rating
				FROM restaurant r, rates ra 
				WHERE r.rid = ra.rid AND r.city = '$SearchPara' 
				GROUP BY r.rid,r.rname, r.street, r.city, 
				r.state, r.zipcode, r.pricerange 
				order by avg(ra.rating) DESC";
			}
			else if($SearchBy == 'Zipcode'){
				
				//calculate nearby restaurants by longitude and latitude assigned to target zipcode with 5 miles range
				$sql = "select r.rid,r.rname,r.street, r.city, r.state, r.zipcode, 	r.pricerange, avg(ra.rating) from restaurant r, rates ra
where r.zipcode IN (select zip
from
(
  SELECT z1.zip as zip, 
    z1.city, 
    ((ACOS(
          SIN(z2.latitude * 3.14 / 180) 
          * SIN(z1.latitude * 3.14 / 180) 
          + COS(z2.latitude * 3.14 / 180) 
          * COS(z1.latitude * 3.14 / 180)
          * COS((z2.longitude - z1.longitude)*3.14 /180))*180/3.14)*60*1.1515) as distance 
  FROM zipcode z1, zipcode z2 WHERE z2.zip = '$SearchPara'
) x
where distance <= 5)
GROUP BY r.rid,r.rname, r.street, r.city, 
				r.state, r.zipcode, r.pricerange 
				order by r.zipcode ASC";
			}
			else if($SearchBy == 'RestaurantName'){
				$SearchPara = strtoupper($SearchPara);
				$sql = "SELECT r.rid, r.rname, r.street, r.city, 
				r.state, r.zipcode, r.pricerange, avg(ra.rating) as rating
				FROM restaurant r, rates ra 
				WHERE r.rid = ra.rid AND UPPER(r.rname) LIKE '%$SearchPara%' 
				GROUP BY r.rid,r.rname, r.street, r.city, 
				r.state, r.zipcode, r.pricerange 
				order by avg(ra.rating) DESC";
			}
			//echo $sql;
			$stid1 = oci_parse($connection, $sql);
			
			//this define must be done before oci_execute
			oci_define_by_name($stid1, 'RID',$rid);
			oci_define_by_name($stid1, 'RNAME',$rname);
			oci_define_by_name($stid1, 'STREET',$street);
			oci_define_by_name($stid1, 'CITY',$city);
			oci_define_by_name($stid1, 'STATE',$state);
			oci_define_by_name($stid1, 'ZIPCODE',$zipcode);
			oci_define_by_name($stid1, 'PRICERANGE',$pricerange);
			oci_define_by_name($stid1, 'RATING', $rating);
			oci_execute($stid1);
			
			$i =1;

			while (oci_fetch($stid1)) {
				if($i == 10){
					$i = 1;
				}
				echo "<hr>";
				echo "<ul class='price-list p2>'";
				echo "<li><h5><a href='restaurant.php?RID=$rid'>$rname</a></h5><span><img src='images/$i.jpg' width='80' height='60'></span></li><br>";
				echo "<li>$street, $city, $state, $zipcode</li>";
				echo "<li>Price: ";
				if($pricerange == 1){
					echo "\$";
				}
				else if($pricerange == 2){
					echo "\$\$";
				}
				else if($pricerange == 3){
					echo "\$\$\$";
				}
				else if($pricerange == 4){
					echo "\$\$\$\$";
				}
				else if($pricerange == 5){
					echo "\$\$\$\$\$";
				}
				echo "</li>";
				echo "<li>Rating: ";
				if (ceil($rating) == 5){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 4){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 3){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating)== 2){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 1){
					echo "<img src='images/gold_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
					echo "<img src='images/gray_star.png' width='15' height='15'>";
				}
				if (ceil($rating) == 0){
					echo "No Ratings";
				}
				echo "</li>";
				echo "</ul>";
				$i++;
			}
			oci_free_statement($stid1);
		}
		oci_close($connection);
            ?>         
    </div>
  </div>
</section>
<!--==============================footer=================================-->
<footer>
  <div class="main">
    <div class="aligncenter"> <span>Copyright &copy; <a href="#">Domain Name</a> All Rights Reserved</span> Design by <a target="_blank" href="http://www.templatemonster.com/">TemplateMonster.com</a> </div>
  </div>
</footer>
<script type="text/javascript">Cufon.now();</script>
<div align=center>This template  downloaded form <a href='http://all-free-download.com/free-website-templates/'>free website templates</a></div></body>
</html>
