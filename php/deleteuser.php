<?php 
    include('connection.php'); 
    session_start();
    if(isset($_GET['id'])) {
        $uid = $_GET["id"];
        $sql = "DELETE FROM users WHERE id='$uid'";
        $message = "";
        if ($db->query($sql) === TRUE) {
            $message = "Record deleted successfully";
        } 
        else {
            $message = "Error deleting record: " . $db->error;
        }
        $_SESSION["isShow"] = true;
        $_SESSION["message"] = $message;
        header("location: ../account.php");
    }
?>
