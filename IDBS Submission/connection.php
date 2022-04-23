<?php
    
    $conect = new mysqli('localhost','root','','opgrs');
    if(!$connect)
    {
        die(mysqli_error($connect));
        
    }

?>