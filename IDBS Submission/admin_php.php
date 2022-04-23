<?php
//session_start();
$servername = "localhost";
$user = "root";
$pass = "" ;
$db = "opgrs";
$connect=mysqli_connect($servername, $user, $pass, $db);
//$email= $_SESSION['email'];
if(!$connect){
    die ("Connection failed:". mysqli_connect_error());
}

// Updates the revenue table 
if(isset($_POST['Updaterevenue'])){
      
    $fdate = $_POST['fdate'];
    $tdate = $_POST['tdate']; 
    $counter ="0";
    //$counter = 1;
    $sql = "SELECT Booking_ID,Cost,From_date FROM bookings WHERE From_date >= '$fdate' and To_date <= '$tdate'";
    $result=$connect->query($sql);
    if($result->num_rows >= 1){
       // echo "works";
       //while(($row = $result->fetch_assoc()==1) || ($counter==1)){
         //   echo "works";
          //  if (is_array($row['Cust_ID'])){
          //      $customerid = $row['Cust_ID'];
          while(($custid_data = mysqli_fetch_array($result))!= NULL) {
          //$custid_data = mysqli_fetch_array($result);
          //$customerid = (array)$custid_data['Cust_ID'];
          $bookid = $custid_data['Booking_ID'];
          $price = $custid_data['Cost'];
          $ufdate = $custid_data['From_date'];
                     
        //    echo $customerid;
            $sql1 = "INSERT INTO revenue (Amount, Booking_ID, Gen_date) VALUES('$price', '$bookid', '$ufdate')";
            //$result1 = $connect->query($sql1);
            //$counter--;
            if($connect->query($sql1)){
               // $counter++;
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql1 . "" . mysqli_error($connect);
               }
               
        }    
    }
    
    mysqli_free_result($result);     
    mysqli_close($connect); 
}     

// generates the report on revenue generated on purticular date

if(isset($_POST['report'])){
      
    $ufdate = $_POST['fdate'];
    $utdate = $_POST['tdate'];
    $usql = "SELECT Gen_date, sum(Amount) as Revenue_Generated FROM revenue 
                WHERE Gen_Date >= '$ufdate' and Gen_date <='$utdate' GROUP BY Gen_date";
    $uresult=$connect->query($usql);
    if($uresult->num_rows >= 1){
        echo "<table>";
        echo "<tr>";
            echo "<th>Generated_Date</th>";
            echo "<th>Revenue_Generated</th>";
        echo "</tr>";


        while(($revenue_data = mysqli_fetch_array($uresult))!= NULL) {
            //$custid_data = mysqli_fetch_array($result);
            //$customerid = (array)$custid_data['Cust_ID'];
            $Revenue = $revenue_data['Revenue_Generated'];
            $Genrated_date = $revenue_data['Gen_date'];

            echo "<tr>";
            echo "<td>" . $revenue_data['Gen_date'] . "</td>";
                echo "<td>" . $revenue_data['Revenue_Generated'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($uresult);
    } else{
        echo "No records matching your query were found.";
    }          
        mysqli_close($connect);    
        }     

// Demonstrates the inner join condition
        if(isset($_POST['join'])){
      
            $jfdate = $_POST['fdate'];
            $jtdate = $_POST['tdate'];
            $jsql = "SELECT bookings.Cust_ID, Cust_Name, Email_Id, Booking_ID, From_date,
                     To_date FROM customer_details INNER JOIN bookings
                     ON customer_details.Cust_ID = bookings.Cust_ID 
                        WHERE From_date >= '$jfdate' and To_date <='$jtdate'";
            $jresult=$connect->query($jsql);
            if($jresult->num_rows >= 1){
                echo "<table>";
                echo "<tr>";
                    echo "<th>Cust_ID</th>";
                    echo "<th>Cust_Name</th>";
                    echo "<th>Email_Id</th>";
                    echo "<th>Booking_ID</th>";
                    echo "<th>From_date</th>";
                    echo "<th>To_date</th>";                    
                echo "</tr>";
        
        
                while(($join_data = mysqli_fetch_array($jresult))!= NULL) {
                    //$custid_data = mysqli_fetch_array($result);
                    //$customerid = (array)$custid_data['Cust_ID'];
                    //$Revenue = $revenue_data['Revenue_Generated'];
                    //$Genrated_date = $revenue_data['Gen_date'];
        
                    echo "<tr>";
                    echo "<td>" . $join_data['Cust_ID'] . "</td>";
                    echo "<td>" . $join_data['Cust_Name'] . "</td>";
                    echo "<td>" . $join_data['Email_Id'] . "</td>";
                    echo "<td>" . $join_data['Booking_ID'] . "</td>";
                    echo "<td>" . $join_data['From_date'] . "</td>";
                    echo "<td>" . $join_data['To_date'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($jresult);
            } else{
                echo "No records matching your query were found.";
            }          
                mysqli_close($connect);    
                }


// Demonstrates the Orderby condition
if(isset($_POST['orderby'])){
      
    $ofdate = $_POST['fdate'];
    $otdate = $_POST['tdate'];
    $osql = "SELECT  Renewal_date,Agreement_date , Owner_Name, Contact  FROM owner_details
                WHERE Renewal_date >= '$ofdate' ORDER BY Renewal_date DESC";
    $oresult=$connect->query($osql);
    if($oresult->num_rows >= 1){
        echo "<table>";
        echo "<tr>";
            echo "<th>Renewal_date</th>";
            echo "<th>Agreement_date</th>";
            echo "<th>Owner_Name</th>";
            echo "<th>Contact</th>";                   
        echo "</tr>";


        while(($order_data = mysqli_fetch_array($oresult))!= NULL) {
            //$custid_data = mysqli_fetch_array($result);
            //$customerid = (array)$custid_data['Cust_ID'];
            //$Revenue = $revenue_data['Revenue_Generated'];
            //$Genrated_date = $revenue_data['Gen_date'];

            echo "<tr>";
            echo "<td>" . $order_data['Renewal_date'] . "</td>";
            echo "<td>" . $order_data['Agreement_date'] . "</td>";
            echo "<td>" . $order_data['Owner_Name'] . "</td>";
            echo "<td>" . $order_data['Contact'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($oresult);
    } else{
        echo "No records matching your query were found.";
    }          
        mysqli_close($connect);    
        }

    // Demonstrates the Search condition
if(isset($_POST['Search'])){
      
    $sfdate = $_POST['fdate'];
    $stdate = $_POST['tdate'];
   
    $ssql = "SELECT Booking_ID, Cust_ID,From_date,To_date,Cost from bookings where From_date = '$sfdate'";
    $sresult=$connect->query($ssql);
    if($sresult->num_rows >= 1){
        echo "<table>";
        echo "<tr>";
            echo "<th>Booking_ID</th>";
            echo "<th>Cust_ID</th>";
            echo "<th>From_date</th>";
            echo "<th>To_date</th>"; 
            echo "<th>Cost</th>";                   

        echo "</tr>";


        while(($search_data = mysqli_fetch_array($sresult))!= NULL) {
            //$custid_data = mysqli_fetch_array($result);
            //$customerid = (array)$custid_data['Cust_ID'];
            //$Revenue = $revenue_data['Revenue_Generated'];
            //$Genrated_date = $revenue_data['Gen_date'];

            echo "<tr>";
            echo "<td>" . $search_data['Booking_ID'] . "</td>";
            echo "<td>" . $search_data['Cust_ID'] . "</td>";
            echo "<td>" . $search_data['From_date'] . "</td>";
            echo "<td>" . $search_data['To_date'] . "</td>";
            echo "<td>" . $search_data['Cost'] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($sresult);
    } else{
        echo "No records matching your query were found.";
    }          
        mysqli_close($connect);    
        }

   // Demonstrates the Having condition
   if(isset($_POST['having'])){
      
    $hfdate = $_POST['fdate'];
    $ftdate = $_POST['tdate'];
    $Avail = 'yes';

    $hsql = "SELECT room_details.PG_ID,PG_Name,Room_Type,count(Room_ID)  FROM pg_details
              INNER JOIN room_details on pg_details.PG_ID = room_details.PG_ID
                WHERE Availability = '$Avail' 
                GROUP BY Room_Type
                Having count(Room_ID) >= 1
                ORDER BY PG_ID ";
    $hresult=$connect->query($hsql);
    if($hresult->num_rows >= 1){
        echo "<table>";
        echo "<tr>";
            echo "<th>PG_ID</th>";
            echo "<th>PG_Name</th>";
            echo "<th>Room_TYPE</th>";
            echo "<th>Count_Rooms</th>";                   
        echo "</tr>";


        while(($having_data = mysqli_fetch_array($hresult))!= NULL) {
            //$custid_data = mysqli_fetch_array($result);
            //$customerid = (array)$custid_data['Cust_ID'];
            //$Revenue = $revenue_data['Revenue_Generated'];
            //$Genrated_date = $revenue_data['Gen_date'];

            echo "<tr>";
            echo "<td>" . $having_data['PG_ID'] . "</td>";
            echo "<td>" . $having_data['PG_Name'] . "</td>";
            echo "<td>" . $having_data['Room_Type'] . "</td>";
            echo "<td>" . $having_data['count(Room_ID)'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($hresult);
    } else{
        echo "No records matching your query were found.";
    }          
        mysqli_close($connect);    
        }


?>