
<?php

$servername = "localhost";
$user = "root";
$pass = "" ;
$db = "opgrs";

$connect=mysqli_connect($servername, $user, $pass, $db);

if(!$connect){
    die ("Connection failed:". mysqli_connect_error());
}

if(isset($_POST['save'])){
    
    $n = $_POST['textnames'];   
    $l = $_POST['phno'];
    $d = $_POST['email'];
    $a = $_POST['pwd'];
    

    $sql = "INSERT INTO customer_details (Cust_Name, Email_Id, Mobile_Num, Password) VALUES
                ('$n', '$d', '$l', '$a')";

if(mysqli_query($connect,$sql)){
  echo '<script>';
 echo 'window.location.href= "login.html"; ';
  echo '</script> ';
} else {
  echo "Error: " . $sql . "" . mysqli_error($connect);
 }
 mysqli_close($connect); 
}

?>