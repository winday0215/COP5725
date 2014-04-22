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
<title>Kravings.com | Sign In/Sign Up</title>
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
<?php
	//$uid = $_GET['USERID'];
?>
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
            <li><a href="allrestaurants.php">TOP 20 Restaurants</a></li>
            <?php            
            if(isset($_SESSION['user'])){
            	$uid = $_SESSION['user'];
            	$email = $_SESSION['email'];
            	$fname = $_SESSION['fname'];
	            $lname = $_SESSION['lname'];
	            $city = $_SESSION['city'];
	            $street = $_SESSION['street'];
	            $state = $_SESSION['state'];
	            $zipcode = $_SESSION['zipcode'];
	            $dob = $_SESSION['dob'];
	            $gender = $_SESSION['gender'];
            	echo "<li><a href='account.php'>Account|</a><a href='logout.php'>Logout</a></li>";
            }
            else {
            	echo "<li><a href='signin.html'>Signin/Signup</a></li>";
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
			  <h3 class="p1">Account Settings >> Profile</h3>
			  <form id="signin-form" name="updateprofile-form" action="php/updateprofile.php" method="post" enctype="multipart/form-data">
				  <fieldset>
				  	 <input type="hidden" id="uid" name="uid" value="<?php echo $uid;?>"/>
					 <label><span class="text-form">Email ID*:</span>
					  	<input name="email" type="text" readonly value="<?php echo $email;?>"/>
					 </label>
					 <label><span class="text-form">First Name*:</span>
					  	<input name="firstname" type="text" readonly value="<?php echo $fname;?>"/>
					 </label>
					 <label><span class="text-form">Last Name*:</span>
					  	<input name="lastname" type="text" readonly value="<?php echo $lname;?>"/>
					 </label>
					 <label><span class="text-form">City*:</span>
					  	<input name="city" type="text" placeholder="<?php echo $city;?>"/>
					 </label>
					<label><span class="text-form">State*:</span>
						<select name="state"> 
						<option value="" selected="selected">Select a State</option> 
						<option value="AL" <?php if($state == "AL" OR $state="Alabama") echo "selected"; ?>>Alabama</option> 
						<option value="AK" <?php if($state == "AK" OR $state="Alaska") echo "selected"; ?>>Alaska</option> 
						<option value="AZ" <?php if($state == "AZ" OR $state="Arizona") echo "selected"; ?>>Arizona</option> 
						<option value="AR" <?php if($state == "AR" OR $state="Arkansas") echo "selected"; ?>>Arkansas</option> 
						<option value="CA" <?php if($state == "CA" OR $state="California") echo "selected"; ?>>California</option> 
						<option value="CO" <?php if($state == "CO" OR $state="Colorado") echo "selected"; ?>>Colorado</option> 
						<option value="CT" <?php if($state == "CT" OR $state="Connecticut") echo "selected"; ?>>Connecticut</option> 
						<option value="DE" <?php if($state == "DE" OR $state="Delaware") echo "selected"; ?>>Delaware</option> 
						<option value="DC" <?php if($state == "DC" OR $state="District Of Columbia") echo "selected"; ?>>District Of Columbia</option> 
						<option value="FL" <?php if($state == "FL" OR $state="Florida") echo "selected"; ?>>Florida</option> 
						<option value="GA" <?php if($state == "GA" OR $state="Georgia") echo "selected"; ?>>Georgia</option> 
						<option value="HI" <?php if($state == "HI" OR $state="Hawaii") echo "selected"; ?>>Hawaii</option> 
						<option value="ID" <?php if($state == "ID" OR $state="Idaho") echo "selected"; ?>>Idaho</option> 
						<option value="IL" <?php if($state == "IL" OR $state="Illinois") echo "selected"; ?>>Illinois</option> 
						<option value="IN" <?php if($state == "IN" OR $state="Indiana") echo "selected"; ?>>Indiana</option> 
						<option value="IA" <?php if($state == "IA" OR $state="Iowa") echo "selected"; ?>>Iowa</option> 
						<option value="KS" <?php if($state == "KS" OR $state="Kansas") echo "selected"; ?>>Kansas</option> 
						<option value="KY" <?php if($state == "KY" OR $state="Kentucky") echo "selected"; ?>>Kentucky</option> 
						<option value="LA" <?php if($state == "LA" OR $state="Louisiana") echo "selected"; ?>>Louisiana</option> 
						<option value="ME" <?php if($state == "ME" OR $state="Maine") echo "selected"; ?>>Maine</option> 
						<option value="MD" <?php if($state == "MD" OR $state="Maryland") echo "selected"; ?>>Maryland</option> 
						<option value="MA" <?php if($state == "MA" OR $state="Massachusetts") echo "selected"; ?>>Massachusetts</option> 
						<option value="MI" <?php if($state == "MI" OR $state="Michigan") echo "selected"; ?>>Michigan</option> 
						<option value="MN" <?php if($state == "MN" OR $state="Minnesota") echo "selected"; ?>>Minnesota</option> 
						<option value="MS" <?php if($state == "MS" OR $state="Mississippi") echo "selected"; ?>>Mississippi</option> 
						<option value="MO" <?php if($state == "MO" OR $state="Missouri") echo "selected"; ?>>Missouri</option> 
						<option value="MT" <?php if($state == "MT" OR $state="Montana") echo "selected"; ?>>Montana</option> 
						<option value="NE" <?php if($state == "NE" OR $state="Nebraska") echo "selected"; ?>>Nebraska</option> 
						<option value="NV" <?php if($state == "NV" OR $state="Nevada") echo "selected"; ?>>Nevada</option> 
						<option value="NH" <?php if($state == "NH" OR $state="New Hampshire") echo "selected"; ?>>New Hampshire</option> 
						<option value="NJ" <?php if($state == "NJ" OR $state="New Jersey") echo "selected"; ?>>New Jersey</option> 
						<option value="NM" <?php if($state == "NM" OR $state="New Mexico") echo "selected"; ?>>New Mexico</option> 
						<option value="NY" <?php if($state == "NY" OR $state="New York") echo "selected"; ?>>New York</option> 
						<option value="NC" <?php if($state == "NC" OR $state="North Carolina") echo "selected"; ?>>North Carolina</option> 
						<option value="ND" <?php if($state == "ND" OR $state="North Dakota") echo "selected"; ?>>North Dakota</option> 
						<option value="OH" <?php if($state == "OH" OR $state="Ohio") echo "selected"; ?>>Ohio</option> 
						<option value="OK" <?php if($state == "OK" OR $state="Oklahoma") echo "selected"; ?>>Oklahoma</option> 
						<option value="OR" <?php if($state == "OR" OR $state="Oregon") echo "selected"; ?>>Oregon</option> 
						<option value="PA" <?php if($state == "PA" OR $state="Pennsylvania") echo "selected"; ?>>Pennsylvania</option> 
						<option value="RI" <?php if($state == "RI" OR $state="Rhode Island") echo "selected"; ?>>Rhode Island</option> 
						<option value="SC" <?php if($state == "SC" OR $state="South Carolina") echo "selected"; ?>>South Carolina</option> 
						<option value="SD" <?php if($state == "SD" OR $state="South Dakota") echo "selected"; ?>>South Dakota</option> 
						<option value="TN" <?php if($state == "TN" OR $state="Tennessee") echo "selected"; ?>>Tennessee</option> 
						<option value="TX" <?php if($state == "TX" OR $state="Texas") echo "selected"; ?>>Texas</option> 
						<option value="UT" <?php if($state == "UT" OR $state="Utah") echo "selected"; ?>>Utah</option> 
						<option value="VT" <?php if($state == "VT" OR $state="Vermont") echo "selected"; ?>>Vermont</option> 
						<option value="VA" <?php if($state == "VA" OR $state="Virginia") echo "selected"; ?>>Virginia</option> 
						<option value="WA" <?php if($state == "WA" OR $state="Washington") echo "selected"; ?>>Washington</option> 
						<option value="WV" <?php if($state == "WV" OR $state="West Virginia") echo "selected"; ?>>West Virginia</option> 
						<option value="WI" <?php if($state == "WI" OR $state="Wisconsin") echo "selected"; ?>>Wisconsin</option> 
						<option value="WY" <?php if($state == "WY" OR $state="Wyoming") echo "selected"; ?>>Wyoming</option>
						</select>
					 </label>
					 <label><span class="text-form">Street:</span>
					  	<input name="street" type="text" placeholder="<?php echo $street;?>"/>
					 </label>
					 <label><span class="text-form">Zipcode:</span>
					  	<input name="zipcode" type="text" placeholder="<?php echo $zipcode;?>"/>
					 </label>
					 <label><span class="text-form">Birthdate:</span>
					  	<input name="DOB" type="text" placeholder="<?php if($dob!='') {echo $dob;} else {echo "dd-mmm-yy";}?>"/>
					 </label>
					 <label><span class="text-form">Gender:</span>
					  	<input name="gender" type="radio" value="M" checked />Male
						<input name="gender" type="radio" value="F"/>Female
					 </label>
					 <div class="wrapper">
						 <div class="extra-wrap">
						 <div class="clear"></div>
                         <div class="buttons1"> <input type="submit" value="Submit"> </div>
                     </div>
                    </div>
			      </fieldset>
			   </form>
      	</div>
      </article>
      <article class="col-2">
      <!--====================================-->
        <div class="wrapper">
	        
        </div>
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
