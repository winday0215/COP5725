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
			echo "<hr>";
			while (oci_fetch($stid)) {
				if($i == 10){
					$i = 1;
				}
				
				echo "<ul id='review-list' class='wrapper'>";
				echo "<li>";
				//display pic
				echo "<div class='summary-left float-left'>
							<img class='summary-pic' src='images/$i.jpg' alt=''>
					 </div>";
				//display restaurant name
				//add review button direct to review.php
				echo "<div class='wrapper review-summary'>
							<span class='float-right'><a href='review.php?RID=$rid&NAME=$rname&USER=1'><input type='button' class='button-orange' value='Add Review'/></a></span>
							<h4 class='summary-title float-left'><a href='restaurant.php?RID=$rid'>$rname</a></h4><div class='afford'>Price: <span class='gold'>";
				//display price range
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
				echo "</span></div>";
				
				//dispaly rating
				$rating = ceil($rating);
				if($rating == 0){
					echo "<p>No Ratings</p>";
				}
				else {
					echo "<p><img src='images/star_0";
					echo $rating.".png' alt=''/><span class='review-count'></span></p>";
				}
				
				//display address
				echo "<div class='most-recent float-left'><h4>Address: </h4></div>";
				echo "<p><span></span>$street, $city, $state, $zipcode<a href='restaurant.php?RID=$rid' class='float-right'>Read Details...</a></p>";
				
				echo "</div>";
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
			//echo $SearchBy;
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
				$sql = "SELECT rs.rid, rs.rname, rs.street, rs.city, 
			rs.state, rs.zipcode, rs.pricerange, rs.distance, avg(ra.rating) as RATING
				FROM 
        (select r.rid, r.rname, r.zipcode, r.street, r.city, r.state, r.pricerange,
				SDO_GEOM.SDO_DISTANCE(z1.GEO, z2.GEO, 0.5,'unit=mile') distance
				FROM zipcode z1, zipcode z2, restaurant r
				Where r.zipcode=z1.zip AND z2.zip = '$SearchPara' AND
				SDO_WITHIN_DISTANCE(z1.GEO, z2.GEO, 'distance=10 unit=mile')='TRUE'
				order by distance ASC) rs, rates ra
				Where rs.rid=ra.rid
				GROUP BY rs.rid, rs.rname, rs.street, rs.city,rs.state, rs.zipcode, rs.pricerange, rs.distance
				ORDER BY rs.distance ASC";
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
			if($SearchBy == 'Zipcode'){
				oci_define_by_name($stid1, 'DISTANCE',$distance);
			}
			oci_define_by_name($stid1, 'RATING', $rating);
			oci_execute($stid1);
			
			$i =1;
			
			if($SearchBy == 'Zipcode'){
				echo "Restaurants Within 10 Miles of ".$SearchPara;
			}
			while (oci_fetch($stid1)) {
			//echo $rname;
				if($i == 10){
					$i = 1;
				}
				echo "<ul id='review-list' class='wrapper'>";
				echo "<li>";
				//display pic
				echo "<div class='summary-left float-left'>
							<img class='summary-pic' src='images/$i.jpg' alt=''>
					 </div>";
				//display restaurant name
				//add review button direct to review.php
				echo "<div class='wrapper review-summary'>
							<span class='float-right'><a href='review.php?RID=$rid&NAME=$rname&USER=1'><input type='button' class='button-orange' value='Add Review'/></a></span>
							<h4 class='summary-title float-left'><a href='restaurant.php?RID=$rid'>$rname</a></h4><div class='afford'>Price: <span class='gold'>";
				//display price range
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
				echo "</span></div>";
				
				//dispaly rating
				$rating = ceil($rating);
				if($rating == 0){
					echo "<p>No Ratings</p>";
				}
				else {
					echo "<p><img src='images/star_0";
					echo $rating.".png' alt=''/><span class='review-count'></span></p>";
				}
				
				//display address
				echo "<div class='most-recent float-left'><h4>Address: </h4></div>";
				echo "<p><span></span>$street, $city, $state, $zipcode<a href='restaurant.php?RID=$rid' class='float-right'>Read Details...</a></p>";
				
				//if search by zipcode, display distance as well
				if($SearchBy == 'Zipcode'){
					echo "<div class='most-recent float-left'><h4>Distance: </h4></div>";
					echo "<p><span></span> ".round($distance,4)." Miles</p>";
				}
				echo "</div>";
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
