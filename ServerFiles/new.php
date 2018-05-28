<!DOCTYPE html>
<html>
<head>
	<title>Pollution Check</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Mina" rel="stylesheet">
</head>
<body>
	<div class = "box">
		<i class = "title_style">Air Pollution Centre</i>
		<img src="icon.jpg" align="right" height="200px">
	</div>
	<div class="bar">
		<ul class="ul_style">
			<li class="li_style"><div class="dropdown">
				    <button class="dropbtn">Node 
				      <i class="fa fa-caret-down"></i>
				    </button>
				    <div class="dropdown-content">
				      <a href="http://airmonitor1.000webhostapp.com/data/new.php?set_node=Node1" style="font-family: 'Mina', san-serif">Node 1</a>
				      <a href="http://airmonitor1.000webhostapp.com/data/new.php?set_node=Node2" style="font-family: 'Mina', san-serif">Node 2</a>
				      <a href="http://airmonitor1.000webhostapp.com/data/new.php?set_node=Node3" style="font-family: 'Mina', san-serif">Node 3</a>
				      <a href="http://airmonitor1.000webhostapp.com/data/new.php?set_node=Node4" style="font-family: 'Mina', san-serif">Node 4</a>
				    </div>
  				</div> 
  			</li>
			<li class="li_style"><a href="">Safe Path</a></li>
			<li class="li_style"><a href="http://uiet.puchd.ac.in/dic/" taget="_blank">About DIC</a></li>
		</ul>
	</div>
	<table id="t01">
		<tr>
			<th id="th1">Serial number</th>
			<th id="th1">Date/Time</th>
			<th id="th1">PPM</th>
			<th id="th1">Temparature</th>
			<th id="th1">Humidity</th>
			<th id="th1">Longitudes</th>
			<th id="th1">Latitudes</th>
		</tr>
		<?php
			$dbusername = "id4997978_ayushmaan"; 
		    $dbpassword = "ayushmaan";  
		    $server = "localhost"; 
		    $dbname = "id4997978_airmonitor";
		    $dbconnect = mysqli_connect($server, $dbusername, $dbpassword, $dbname);
		    $sql = "SELECT * FROM ".$_GET["set_node"];
		    $result=mysqli_query($dbconnect,$sql);
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
		?>
	</table>
	<?php
	$sql2 = "SELECT * FROM ".$_GET["set_node"]." ORDER BY SerialNo DESC";
    $result2=mysqli_query($dbconnect,$sql2);
	$row = mysqli_fetch_assoc($result2);
	$lattitude = $row["Lattitude"];
	$longitude = $row["Longitude"];
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
    top: 270px;
    right: 10px;
    background: #100680;
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
<h3 style='color:white;align:centre;'>Node Location</h3>
<div id='map' style='width:400px;height:350px;background:green'></div>
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