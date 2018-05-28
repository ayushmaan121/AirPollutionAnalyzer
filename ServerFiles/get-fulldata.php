<?php
    // localhost/write_data1.php?ppm=100&temp=110&humid=120
    
    $dbusername = "id4997978_ayushmaan"; 
    $dbpassword = "ayushmaan";  
    $server = "localhost"; 
    $dbname = "id4997978_airmonitor";
    $date= $_GET["set_date"];
   // echo $date;
    //$date = "05/03/2018";
    $dbconnect = mysqli_connect($server, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT * FROM ".$_GET["set_node"]." WHERE Date = '$date'";
    $result=mysqli_query($dbconnect,$sql);
    if (mysqli_num_rows($result) > 0) {
       while($row = mysqli_fetch_assoc($result)){
          echo $row["SerialNo"]. " , " . $row["DateTime"]. " , " . $row["PPMValue"]. " , " . $row["Temperature"]. " , " . $row["Humidity"]."\n";
       }
    }else {
       echo "";
    }
    
?>

