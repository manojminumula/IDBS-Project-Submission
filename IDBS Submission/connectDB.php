
<?php

$servername = "localhost";
$user = "root";
$pass = "" ;
$db = "opgrs";

$connect=mysqli_connect($servername, $user, $pass, $db);

if(!$connect){
    die ("Connection failed:". mysqli_connect_error());
}


?>