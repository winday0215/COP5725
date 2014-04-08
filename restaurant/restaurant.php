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
        <div>
                <?php
        $rid = $_GET['RID'];
        //check if it's a search result
        $connection = oci_connect($username = 'jing',
                          $password = 'spring123456',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
                          
            //choose restaurants, calculate average rating and display by averate rating DESC order
        $sql = "SELECT r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange,r.openhrs, r.closehrs, r.wifi, r.url, res.rating, count(re.reviewid) as reviews
			FROM 
      (SELECT r1.rid as RID, avg(ra.rating)as rating FROM restaurant r1, rates ra
      WHERE r1.rid = ra.rid
      GROUP BY r1.rid) res, review re, restaurant r
      WHERE res.rid = re.rid AND res.rid = r.rid  AND r.rid = $rid
			GROUP BY r.rid, r.rname, r.street, r.city, 
			r.state, r.zipcode, r.pricerange,r.openhrs, r.closehrs, r.wifi, r.url, res.rating";
				
		$stid = oci_parse($connection,$sql);
		oci_define_by_name($stid, 'RNAME',$rname);
		oci_define_by_name($stid, 'STREET',$street);
		oci_define_by_name($stid, 'CITY',$city);
		oci_define_by_name($stid, 'STATE',$state);
		oci_define_by_name($stid, 'ZIPCODE',$zipcode);
		oci_define_by_name($stid, 'PRICERANGE',$pricerange);
		oci_define_by_name($stid, 'OPENHRS',$open);
		oci_define_by_name($stid, 'CLOSEHRS',$close);
		oci_define_by_name($stid, 'WIFI',$wifi);
		oci_define_by_name($stid, 'PHONE',$phone);
		oci_define_by_name($stid, 'URL',$url);
		oci_define_by_name($stid, 'REVIEWS',$numreview);
		oci_define_by_name($stid, 'RATING', $rating);
		oci_execute($stid);
		
		
		//xxxx
		$i =1;
		while (oci_fetch($stid)){
			echo "<h3 class='prev-indent-bot'>$rname</a></h3>";
			echo "<hr>";
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
							<div class='afford'>Price: <span class='gold'>";
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
				
				$rating = round($rating);
				if($rating == 0){
					echo "<p>No Ratings</p>";
				}
				else {
					echo "<p><img src='images/star_0";
					echo $rating.".png' alt=''/><span class='review-count'>$numreview Reviews</span></p>";
				}
				
				//display address
				echo "<div class='most-recent float-left'><h4>Address: </h4></div>";
				echo "<p><span></span>$street, $city, $state, $zipcode";
				if($url != null){
					echo "<a href='".$url."' class='float-right'>Go To WebSite</a>";
				}
				echo "</p>";
				
				//display phone number
				echo "<div class='most-recent float-left'><h4>Phone: </h4></div>";
				echo "<p><span></span>$phone</p>";
				
				//open and close time
				echo "<div class='most-recent float-left'><h4>Today: </h4></div>";
				echo "<p><span></span>".$open. " - ". $close."</p>";
				
				if($wifi == 'Y'){
					echo "<div class='most-recent float-left'><h4>WIFI Available</h4></div>";
				}
				
				
				echo "</div>";
				echo "</li>";
				echo "</ul>";
			}
		
		//xxx
		
		echo "<br><br><br>";
		
		
		$sql = "select u.FNAME, u.city, u.STATE, ra.rating, r.content from review r, useraccount u, rates ra
					where r.RID=$rid AND r.USERID = u.USERID AND r.USERID= ra.USERID AND r.RID=ra.RID";
			//echo $sql;
		$stid = oci_parse($connection,$sql);
		oci_define_by_name($stid, 'FNAME',$fname);
		oci_define_by_name($stid, 'CITY',$ucity);
		oci_define_by_name($stid, 'STATE',$ustate);
		oci_define_by_name($stid, 'RATING',$urating);
		oci_define_by_name($stid, 'CONTENT',$reviewcontent);
		oci_execute($stid);
			
		
		//&&&&
		echo "<h3 class='prev-indent-bot'>Recommended Reviews</h3>";
		echo "<hr>";
		while(oci_fetch($stid)){
			
			echo "<ul id='review-list' class='wrapper'>";
			echo "<li>";	
			echo "<div class='summary-left float-left'>
							<p><b><i>".$fname."</i></b></p>
							<p>$ucity, $ustate</p>
				  </div>";			
			
	
			echo "<p><img src='images/star_0";
			echo $urating.".png' alt=''/><span class='review-count'></span></p>";
				
			echo "<p>".$reviewcontent."</p>";
			
			echo "</li>";
			echo "</ul>";
		}
		//&&&&
		
		oci_free_statement($stid);
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
