<?php
session_start();
$servername = "localhost";
$user = "root";
$pass = "" ;
$db = "opgrs";
$connect=mysqli_connect($servername, $user, $pass, $db);
$email= $_SESSION['email'];
if(!$connect){
    die ("Connection failed:". mysqli_connect_error());
}

if(isset($_POST['butbook'])){
    
    $cost = "200";   
    $fdate = $_POST['fdate'];
    $tdate = $_POST['tdate']; 
    //$counter = 1;
    $sql = "SELECT Cust_ID FROM customer_details WHERE Email_Id = '$email'";
    $result=$connect->query($sql);
    if($result->num_rows == 1){
       // echo "works";
       //while(($row = $result->fetch_assoc()==1) || ($counter==1)){
         //   echo "works";
          //  if (is_array($row['Cust_ID'])){
          //      $customerid = $row['Cust_ID'];
          $custid_data = mysqli_fetch_array($result);
          //$customerid = (array)$custid_data['Cust_ID'];
          $customerid = $custid_data['Cust_ID'];
           }
            
        //    echo $customerid;
            $sql1 = "INSERT INTO bookings (From_date, To_date, Cost, Cust_ID) VALUES('$fdate', '$tdate', '$cost', '$customerid')";
            //$result1 = $connect->query($sql1);
            //$counter--;
            if($connect->query($sql1)){
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql1 . "" . mysqli_error($connect);
               }
            
        mysqli_close($connect);    
        }     


        if(isset($_POST['updbook'])){
      
            $ufdate = $_POST['fdate'];
            $utdate = $_POST['tdate'];
            $usql = "SELECT Cust_ID FROM customer_details WHERE Email_Id = '$email'";
            $uresult=$connect->query($usql);
            if($uresult->num_rows == 1){
                  $ucustid_data = mysqli_fetch_array($uresult);
                  $ucustomerid = $ucustid_data['Cust_ID'];
                   }
                $sql2 = " UPDATE bookings SET From_date = '$ufdate',
                To_date = '$utdate' WHERE  Cust_ID = '$ucustomerid' ";
                    $result2 = $connect->query($sql2);
                    if($connect->query($sql2)){
                        echo "record Updated successfully";
                      } else {
                        echo "Error: " . $sql2 . "" . mysqli_error($connect);
                       }
                    
                mysqli_close($connect);    
                }     
        
        
                if(isset($_POST['delbook'])){
      
                    $dsql = "SELECT Cust_ID FROM customer_details WHERE Email_Id = '$email'";
                    $dresult=$connect->query($dsql);
                    if($dresult->num_rows == 1){
                          $dcustid_data = mysqli_fetch_array($dresult);
                          $dcustomerid = $dcustid_data['Cust_ID'];
                           }
                        $sql3 = " DELETE from bookings where Cust_ID = '$dcustomerid'";
                            if($connect->query($sql3)){
                                echo "record deleted successfully";
                              } else {
                                echo "Error: " . $sql3 . "" . mysqli_error($connect);
                               }
                            
                        mysqli_close($connect);    
                        }     


        

?>