<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['user'])){
	echo "<script type='text/javascript'>alert('You must login at first!')</script>";
		//setcookie("user",$id, time()+3600);
	echo "<script type='text/javascript'>window.location.replace('signin.html');</script>";
}
?>
<html lang="en">
<head>
<title>Kravings.com | Sing In/Sign Up</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Dynalight_400.font.js" type="text/javascript"></script>
<script src="js/FF-cash.js" type="text/javascript"></script>
<script src="js/jquery.equalheights.js" type="text/javascript"></script>
<script src="js/jquery.bxSlider.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#slider').bxSlider({
        pager: true,
        controls: false,
        moveSlideQty: 1,
        displaySlideQty: 3
    });
});
</script>
<!--[if lt IE 9]><script type="text/javascript" src="js/html5.js"></script><![endif]-->
</head>
<body id="page2">
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
            <li><a href="allrestaurants.php">Restaurants</a></li>
            <li><a href="contact.html">Contact</a></li>
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
    <div class="wrapper">
      <article class="col-1">
      	<div class="indent-left">
			  <!--=================Sign In===================-->
			  <h3 class="p1">Account Settings >> Overview</h3>
			  <hr>
			  <div>
				  <p><h4><a href="profile.php">Profile</a></h4></p>
				  <p>Edit your name, public profile information, and your Member Search preference.</p>
			  </div>
			  <hr>
			  <div>
				  <p><h4><a href="password.php">Password</a></h4></p>
				  <p>Change the password for your Kravings Account.</p>
			  </div>
			  <hr>
      	</div>
      </article>
      <article class="col-2">
      <!--=================Sign Up===================-->
      </article>
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
