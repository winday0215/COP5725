<!DOCTYPE html>
<?php
session_start();
?>
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
        <h1><a href="index.php">Kravings<span>.com</span></a></h1>
        <nav>
          <ul class="menu">
            <li>      
          		<form id="search-form" action="search.php" method="post"> 
			  		<input type="text" id="tb7" name="searchkey" id="searchkey"/>
			  		<select name="searchtype" id="searchtype">
				  		<option id="">--Search By--</option>
				  		<option id="city">City</option>
				  		<option id="name">Restaurant Name</option>
				  		<option id="zipcode">Zipcode</option>
				  		<option id="cuisine">Cuisine</option>
			  		</select>
			  		<input type="submit" name="searchsubmit" value="Go" class="sub1"> 
			  	</form>
      		</li>
            <li><a href="index.php">Home</a></li>
            <li><a href="allrestaurants.php">TOP 20 Restaurants</a></li>
            <?php            
            if(isset($_SESSION['user'])){
            	$uid = $_SESSION['user'];
            	$fname = $_SESSION['fname'];
            	echo "<li><a href='account.php'>Account|</a><a href='logout.php'>Logout</a></li>";
            }
            else {
            	echo "<li><a href='signin.html'>Singin/Signup</a></li>";
            }
            ?>
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
            echo "<h3 class='prev-indent-bot'>Top 20 Restaurant List</h3><div>";
            if($uid == ""){
            //echo $uid;
			$sql =
			"SELECT * FROM (SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra
      WHERE r1.rid = ra.rid
      GROUP BY r1.rid) res, review re, restaurant r, cuisine c, resc rc
      WHERE res.rid = re.rid AND res.rid = r.rid AND r.rid = rc.rid AND rc.cuisineid = c.cuisineid
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating 
      order by avg(res.rating) DESC)
      WHERE rownum <= 20";
      		}
      		else{
      		//echo $uid;
	      		$sql=
			"SELECT * FROM (SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra, useraccount u
      WHERE r1.rid = ra.rid AND u.userid = $uid AND u.city = r1.city
      GROUP BY r1.rid) res, review re, restaurant r, cuisine c, resc rc
      WHERE res.rid = re.rid AND res.rid = r.rid AND r.rid = rc.rid AND rc.cuisineid = c.cuisineid
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating 
      order by avg(res.rating) DESC) WHERE rownum<=20";
      		}
			$stid = oci_parse($connection, $sql);
			//this define must be done before oci_execute
			oci_execute($stid);
			
			
			$nrows = oci_fetch_all($stid, $res);
			echo $nrows." restaurants in total.";
			echo "<hr>";
			for($i=0; $i < $nrows; $i++){
				$rid = $res['RID'][$i];
				$rname = $res['RNAME'][$i];
				$street = $res['STREET'][$i];
				$city = $res['CITY'][$i];
				$state = $res['STATE'][$i];
				$zipcode = $res['ZIPCODE'][$i];
				$pricerange = $res['PRICERANGE'][$i];
				$cuisinename = $res['CUISINENAME'][$i];
				$rating = $res['RATING'][$i];
				$reviews = $res['REVIEWS'][$i];
				
				echo "<ul id='review-list' class='wrapper'>";
				echo "<li>";
				//display pic
				$index = rand(1,10);
				echo "<div class='summary-left float-left'>
							<img class='summary-pic' src='images/$index.jpg' alt=''>
					 </div>";
				//display restaurant name
				//add review button direct to review.php
				echo "<div class='wrapper review-summary'>
							<span class='float-right'><a href='review.php?RID=$rid&NAME=$rname&USER=1'><input type='button' class='button-orange' value='Add Review'/></a></span>
							<h4 class='summary-title float-left'><a href='restaurant.php?RID=$rid'>$rname</a></h4><div class='afford'><span class='gold'>";
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
				echo " ."."</span><span>"." "."$cuisinename</span></div>";
				
				//dispaly rating
				$rating = round($rating);
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

			}
			oci_free_statement($stid);
		}
		
		//display searched restaurant
		else {
			echo "<h3 class='prev-indent-bot'>Restaurant List</h3><div>";
			//echo $SearchBy;
			if($SearchBy == 'City'){
				$sql = "SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra
      WHERE r1.rid = ra.rid
      GROUP BY r1.rid) res, review re, restaurant r, CUISINE c, RESC rc
      WHERE res.rid = re.rid AND res.rid = r.rid AND r.rid = rc.rid AND rc.cuisineid = c.cuisineid AND r.city = '$SearchPara'
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, c.cuisinename, res.rating 
      order by avg(res.rating) DESC";
			}
			else if($SearchBy == 'Zipcode'){
				
				//calculate nearby restaurants by longitude and latitude assigned to target zipcode with 5 miles range
				$sql = "SELECT rs.rid, rs.rname, rs.street, rs.city, 
			rs.state, rs.zipcode, rs.pricerange, rs.distance, c.cuisinename, avg(ra.rating) as RATING
				FROM 
        (select r.rid, r.rname, r.zipcode, r.street, r.city, r.state, r.pricerange,
				SDO_GEOM.SDO_DISTANCE(z1.GEO, z2.GEO, 0.5,'unit=mile') distance
				FROM zipcode z1, zipcode z2, restaurant r
				Where r.zipcode=z1.zip AND z2.zip = '$SearchPara' AND
				SDO_WITHIN_DISTANCE(z1.GEO, z2.GEO, 'distance=10 unit=mile')='TRUE'
				order by distance ASC) rs, rates ra, CUISINE c, RESC rc
				Where rs.rid=ra.rid AND rs.rid = rc.RID AND rc.CUISINEID = c.CUISINEID
				GROUP BY rs.rid, rs.rname, rs.street, rs.city,rs.state, rs.zipcode, rs.pricerange, rs.distance, c.cuisinename
				ORDER BY rs.distance ASC";
			}
			else if($SearchBy == 'RestaurantName'){
				$SearchPara = strtoupper($SearchPara);
				$sql = "SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, res.rating, c.cuisinename, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra
      WHERE r1.rid = ra.rid
      GROUP BY r1.rid) res, review re, restaurant r, cuisine c, resc rc
      WHERE res.rid = re.rid AND res.rid = r.rid AND r.rid = rc.rid AND rc.cuisineid=c.cuisineid AND UPPER(r.rname) LIKE '%$SearchPara%'
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, res.rating, c.cuisinename
      order by avg(res.rating) DESC";
			}
			else if($SearchBy == 'Cuisine'){
				$SearchPara = strtoupper($SearchPara);
				$sql = "SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, res.rating, c.cuisinename, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra
      WHERE r1.rid = ra.rid
      GROUP BY r1.rid) res, review re, restaurant r, cuisine c, resc rc
      WHERE res.rid = re.rid AND res.rid = r.rid AND r.rid = rc.rid AND rc.cuisineid=c.cuisineid AND UPPER(c.cuisinename) LIKE '%$SearchPara%'
			GROUP BY r.rid,r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange, res.rating, c.cuisinename
      order by avg(res.rating) DESC";
			}
			//echo $sql;
			$stid1 = oci_parse($connection, $sql);
			oci_execute($stid1);
			
			
			if($SearchBy == 'Zipcode'){
				echo "Restaurants Within 10 Miles of ".$SearchPara."<br>";
			}
			$nrows = oci_fetch_all($stid1, $res);
			/*
				pages
			*/
			$pages = intval($nrows/20);
			if($nrows % 20){
				$pages++;
			}
			if(isset($_GET['PAGENUM'])){
				$pagenum = $_GET['PAGENUM'];
			}
			else{
				$pagenum = 1;
			}
			$offset = ($pagenum-1)*20;
			
			echo "<div>";
			echo $nrows." restaurants in total.";
			
			echo "<span style='float:right;'>Total $pages Pages</span>";
			echo "<span style='float:right;padding:2px;'> | </span>";
			
				
			echo "<span style='float:right;'><a href='allrestaurants.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$pages'>Last Page</a></span>";

			
			
			
			if($pagenum != $pages){
				echo "<span style='float:right;padding:2px;'> | </span>";
				$postpage = $pagenum+1;
				echo "<span style='float:right;'><a href='allrestaurants.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$postpage'>Next Page</a></span>";
			}
			
			if($pagenum != 1){
				echo "<span style='float:right;padding:2px;'> | </span>";
				$prepage = $pagenum-1;
				echo "<span style='float:right;'><a href='allrestaurants.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$prepage'>Previous Page</a></span>";
			}
			echo "<span style='float:right;padding:2px;'> | </span>";


			echo "<span style='float:right;'><a href='allrestaurants.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=1'>First Page</a></span>";
			echo "</div>";
			/*
				
				END of pages
			*/
			
			
			echo "<hr>";
			
			$maxcount = min(20, $nrows - $offset);
			for($i=$offset; $i < $offset + $maxcount; $i++){
			//echo $rname;
				$rid = $res['RID'][$i];
				$rname = $res['RNAME'][$i];
				$street = $res['STREET'][$i];
				$city = $res['CITY'][$i];
				$state = $res['STATE'][$i];
				$zipcode = $res['ZIPCODE'][$i];
				$pricerange = $res['PRICERANGE'][$i];
				$cuisinename = $res['CUISINENAME'][$i];
				$rating = $res['RATING'][$i];
				$reviews = $res['REVIEWS'][$i];
				if($SearchBy == 'Zipcode'){
					$distance = $res['DISTANCE'][$i];
				}
				
				
				echo "<ul id='review-list' class='wrapper'>";
				echo "<li>";
				//display pic
				$index = rand(1,10);
				echo "<div class='summary-left float-left'>
							<img class='summary-pic' src='images/$index.jpg' alt=''>
					 </div>";
				//display restaurant name
				//add review button direct to review.php
				echo "<div class='wrapper review-summary'>
							<span class='float-right'><a href='review.php?RID=$rid&NAME=$rname&USER=1'><input type='button' class='button-orange' value='Add Review'/></a></span>
							<h4 class='summary-title float-left'><a href='restaurant.php?RID=$rid'>$rname</a></h4><div class='afford'><span class='gold'>";
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
				echo " ."."</span><span>"." "."$cuisinename</span></div>";
				
				//dispaly rating
				$rating = round($rating);
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
			}
			echo "<div>";
			echo $nrows." restaurants in total.";
			
			echo "<span style='float:right;'>Total $pages Pages</span>";
			echo "<span style='float:right;padding:2px;'> | </span>";
			
				
			echo "<span style='float:right;'><a href='test.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$pages'>Last Page</a></span>";

			
			
			
			if($pagenum != $pages){
				echo "<span style='float:right;padding:2px;'> | </span>";
				$postpage = $pagenum+1;
				echo "<span style='float:right;'><a href='test.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$postpage'>Next Page</a></span>";
			}
			
			if($pagenum != 1){
				echo "<span style='float:right;padding:2px;'> | </span>";
				$prepage = $pagenum-1;
				echo "<span style='float:right;'><a href='test.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=$prepage'>Previous Page</a></span>";
			}
			echo "<span style='float:right;padding:2px;'> | </span>";


			echo "<span style='float:right;'><a href='test.php?SearchBy=$SearchBy&SearchPara=$SearchPara&PAGENUM=1'>First Page</a></span>";
			echo "</div>";
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
