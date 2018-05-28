<?php
if (isset($_GET['ppm']) && isset($_GET['temp']) && isset($_GET['humid']) && isset($_GET['lattitude']) && isset($_GET['longitude'])) {
    $ppm = $_GET['ppm'];
    $temp = $_GET['temp'];
    $humid = $_GET['humid'];
    $lattitude = $_GET['lattitude'];
    $longitude = $_GET['longitude'];
    $date = date("Y-m-d");
    $dbusername = "id4997978_ayushmaan"; 
    $dbpassword = "ayushmaan";  
    $server = "localhost"; 
    $dbname = "id4997978_airmonitor";
    $dbconnect = mysqli_connect($server, $dbusername, $dbpassword, $dbname);
    $result = mysqli_query($dbconnect,"INSERT INTO Node1(PPMValue, Temperature, Humidity, Lattitude, Longitude, Date) VALUES( '$ppm','$temp','$humid', '$lattitude', '$longitude', '$date')");
}
?>
