<html>
<head>
<title>Iot Based Analyzer</title>
<style type="text/css">
table{
border:5px solid red;
background-color: #96C623;
}
th{
border-bottom: 5px solid #1E474F;
}
td{
border-bottom: 2px solid #1E474F;
}
div.transbox {
  margin: 5px;
  background-color: #ffffff;
  border: 1px solid black;
  opacity: 1;
  filter: alpha(opacity=100); /* For IE8 and earlier */
}

div.transbox p {
  margin: 30%;
  font-weight: bold;
  color: #000000;
}
</style>
</head>
<body>

<div class="background">
  <div class="transbox">
    <h1> <img src= "try.jpg" alt = "logo" align= "left"><br /><br />Design And Innovation Center<br /><br /><h4>(Project Sponsored by MHRD under HUB and Spokes Model)</h4></h1>
  </div>
</div>

</body>
<a href="http://trial111.000webhostapp.com/api/weather/trial.php?set_node=Node1"><button>Node1</button></a>
<a href="http://trial111.000webhostapp.com/api/weather/trial.php?set_node=Node2"><button>Node2</button></a>
<a href="http://trial111.000webhostapp.com/api/weather/trial.php?set_node=Node3"><button>Node3</button></a>
<a href="http://trial111.000webhostapp.com/api/weather/trial.php?set_node=Node4"><button>Node4</button></a>
<body bgcolor=" #f5b041   ">
<?php
	$dbusername = "id4663607_trialtest"; 
    $dbpassword = "trialtest";  
    $server = "localhost"; 
    $dbname = "id4663607_trialtest";
    $dbconnect = mysqli_connect($server, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT * FROM ".$_GET["set_node"];
    $result=mysqli_query($dbconnect,$sql);
    echo "Selected Node: ";
    echo $_GET["set_node"];
	echo "<table>";
	echo "<tr><th>SerialNo</th><th>DateTime</th><th>PPMValue</th><th>Temperature</th><th>Humidity</th><th>Lattitutde</th><th>Longitude</th>";
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
	echo "<tr><td>";
	echo $row["SerialNo"];
	echo "</td><td>";
	echo $row["DateTime"];
	echo "</td><td>";
	echo $row["PPMValue"];
	echo "</td><td>";
	echo $row["Temperature"];
	echo "</td><td>";
	echo $row["Humidity"];
	echo "</td><td>";
	echo $row["Lattitude"];
	echo "</td><td>";
	echo $row["Longitude"];
	echo "</td></tr>";
	}
}
	echo "</table>";
	//echo "hello";
	$sql2 = "SELECT * FROM ".$_GET["set_node"]." ORDER BY SerialNo DESC";
    $result2=mysqli_query($dbconnect,$sql2);
	//$totalrows = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result2);
	$lattitude = $row["Lattitude"];
	$longitude = $row["Longitude"];
	//echo "$totalrows";
	//$lattitude = 30.75;
	//$longitude = 76.76;
	echo "<html>
<head>
<style>
body {
    font-family: 'Lato', sans-serif;
}
.sidenav {
    width: 400px;
    position: fixed;
    z-index: 1;
    top: 150px;
    right: 10px;
    background: #eee;
    overflow-x: hidden;
    padding: 8px 0;
}
.sidenav a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 25px;
    color: #2196F3;
    display: block;
}
.sidenav a:hover {
    color: #064579;
}
.main {
    margin-left: 140px;
    font-size: 28px;
    padding: 0px 10px;
}
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>
<div class='sidenav'>
 <body>
<h3>Current Location</h3>
<div id='map' style='width:400px;height:400px;background:green'></div>
<script>
function myMap() {
var mark = {lat: $lattitude, lng: $longitude};
var mapOptions = {
    center: new google.maps.LatLng($lattitude, $longitude),
    zoom: 17,
    mapTypeId: google.maps.MapTypeId.HYBRID
}
var map = new google.maps.Map(document.getElementById('map'), mapOptions);
var marker = new google.maps.Marker({
          position: mark,
          map: map
        });
}
</script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBMfugdh5tdoDwWrmu2uXVXA-VMLlTvLPc&callback=myMap'></script>
</body>
</div>
</body>
</html> 
";
?>
</body>
</html>