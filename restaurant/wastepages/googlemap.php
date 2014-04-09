<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>
<?php
     // Get lat and long by address         
        $address = "4440 SW Archer Road,Gainesville,FL,32608"; // Google HQ
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        echo $latitude;
        echo $longitude;
?>

<script>
function initialize()
{
var myLatlng = new google.maps.LatLng(<?php echo $latitude?>,<?php echo $longitude?>);
var mapProp = {
  center:myLatlng,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
var map=new google.maps.Map(document.getElementById('googleMap')
  ,mapProp);
  
var marker=new google.maps.Marker({
  position:myLatlng,
  map: map,
  });


}
google.maps.event.addDomListener(window, 'load', initialize);
</script>


</head>

<body>
<div id="googleMap" style="width:500px;height:380px;"></div>

</body>
</html>