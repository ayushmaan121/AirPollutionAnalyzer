<?php
    // localhost/write_data1.php?ppm=100&temp=110&humid=120
    
    $dbusername = "id4997978_ayushmaan"; 
    $dbpassword = "ayushmaan";  
    $server = "localhost"; 
    $dbname = "id4997978_airmonitor";
    $dbconnect = mysqli_connect($server, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT * FROM ".$_GET["set_node"]." ORDER BY SerialNo DESC LIMIT 1";
    $result=mysqli_query($dbconnect,$sql);
    //echo $result;
    if (mysqli_num_rows($result) == 1) {
       $row = mysqli_fetch_assoc($result);
          echo $row["PPMValue"]. ":" . $row["Temperature"]. ":" . $row["Humidity"] . ":" . $row["Lattitude"] . ":" . $row["Longitude"];
    }
    
?>
