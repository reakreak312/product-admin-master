<?php 
    include('connection.php'); 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
        $myposition = mysqli_real_escape_string($db,$_POST['position']); 
        $myname = mysqli_real_escape_string($db,$_POST['name']); 
        $myemail = mysqli_real_escape_string($db,$_POST['email']);
        $myphone = mysqli_real_escape_string($db,$_POST['phone']);
        $mygender = mysqli_real_escape_string($db,$_POST['gender']);
        $message = "";
        if($_POST['password'] == $_POST['password2']){
            $sql = "INSERT INTO users (username,password,position,name,email,phone,gender) 
            VALUES ('$myusername', '$mypassword', '$myposition', '$myname', '$myemail', '$myphone','$mygender')";
            if ($db->query($sql) === TRUE) {
                $message = "New record created successfully";
            } 
            else {
                $message = "Error: " . $sql . "<br>" . $db->error;
            }
        }
        else {
            $message = "Incorrect Re-enter password.";
        } 
        $_SESSION["isShow"] = true;
        $_SESSION["message"] = $message;
        header("location: ../account.php");
    }
?>