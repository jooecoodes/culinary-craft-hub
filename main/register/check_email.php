<?php 
require_once("../db_conn.php");


if(isset($_POST['email'])) {
    $userEmail = htmlspecialchars($_POST['email']);
    $selectionSql = "SELECT * FROM user WHERE useremail = '$userEmail'";
    $result = mysqli_query($conn, $selectionSql);
    $identifier = verifyEmail($userEmail);

    if(mysqli_num_rows($result) > 0) {
        echo "userexist";
    } else {
        if($identifier) {
            echo "Email is valid";
         } else {
             echo "Email is invalid";
         }
    }
    

  
}

function verifyEmail($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}


?>