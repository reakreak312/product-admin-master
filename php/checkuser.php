<?php 
    include('connection.php'); 
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
        
        $sql = "SELECT id FROM users WHERE username = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);        
        $count = mysqli_num_rows($result);
        if($count == 1) {
            $_SESSION["id"] = $row['id'];
            header("location: ../account.php");
        }
        else {
            $_SESSION["isIncorrect"] = true;
            header("location: ../login.php");
        }
        // if (!$count) {
        //     printf("error db: %s\n", mysqli_error($db));
        //     exit();
        // }
    }
?>