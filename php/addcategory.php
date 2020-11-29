<?php 
    include('connection.php'); 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $mycategory_name = mysqli_real_escape_string($db,$_POST['category_name']);
        if($mycategory_name != ''){
            $icon_class = mysqli_real_escape_string($db,$_POST['icon_class']);
            $message = "";
            $sql = "INSERT INTO categorys (category_name,icon_class) VALUES ('$mycategory_name','$icon_class')";
            if ($db->query($sql) === TRUE) {
                $message = "New record created successfully";
            } 
            else {
                $message = "Error: " . $sql . "<br>" . $db->error;
            }
            $_SESSION["isShow"] = true;
            $_SESSION["message"] = $message;
        }
        header("location: ../product.php");
    }
?>