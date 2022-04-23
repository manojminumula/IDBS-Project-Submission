<?php

session_start();
// Grab User submitted information
$email = $_POST["emailid"];
$password = $_POST["password"];
$_SESSION['email'] = $email; //change the value and get from database later
$servername = "localhost";
$user = "root";
$pass = "" ;
$db = "opgrs";

// Connect to the database
$con=mysqli_connect($servername, $user, $pass, $db);
// $con = mysqli_connect("localhost","root","");
// Make sure we connected successfully
if(! $con)
{
    die('Connection Failed'.mysqli_error());
}
// Select the database to use
// mysqli_select_db("opgrs",$con);


$sql="SELECT * FROM customer_details WHERE Email_Id='$email' and Password='$password'";
$result=mysqli_query($con, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
echo '<script>';
 echo 'window.location.href= "locations.html"; ';
 echo '</script> ';
}
else {
//echo "$email, $pass, $count";
echo "Wrong Username or Password";

}
?>