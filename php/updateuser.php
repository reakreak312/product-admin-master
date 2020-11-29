<?php 
    include('connection.php'); 
    session_start();
    $_SESSION["id"];
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);  
    }
    if(isset($_GET['update'])){
        $myusername = mysqli_real_escape_string($db,$_GET['username']);
        $mypassword = mysqli_real_escape_string($db,$_GET['password']); 
        $myposition = mysqli_real_escape_string($db,$_GET['position']); 
        $myname = mysqli_real_escape_string($db,$_GET['name']); 
        $myemail = mysqli_real_escape_string($db,$_GET['email']);
        $myphone = mysqli_real_escape_string($db,$_GET['phone']);
        $myid = mysqli_real_escape_string($db,$_GET['id']);
        $sql = "UPDATE users SET username='$myusername',password='$mypassword',position='$myposition',name='$myname',email='$myemail',phone='$myphone' WHERE id='$myid'"; 
        $message = "";
        if ($db->query($sql) === TRUE) {
            $message = "Record updated successfully";
        } 
        else {
            $message = "Error updating record: " . $db->error;
        }
        $_SESSION["isShow"] = true;
        $_SESSION["message"] = $message;
        header("location: ../account.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Update User</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700"
        />
        <!-- https://fonts.google.com/specimen/Roboto -->
        <link rel="stylesheet" href="../css/fontawesome.min.css" />
        <!-- https://fontawesome.com/ -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- https://getbootstrap.com/ -->
        <link rel="stylesheet" href="../css/templatemo-style.css">
        <!--
        Product Admin CSS Template
        https://templatemo.com/tm-524-product-admin
        -->
    </head>
    <body>
        <div class="container mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal" href="../account.php">Close</a>
                </div>
                <div class="modal-body">
                    <div class="row tm-content-row">
                        <div class="tm-block-col tm-col-avatar">
                            <div class="tm-bg-primary-dark tm-block tm-block-avatar">
                                <h2 class="tm-block-title">Change Avatar</h2>
                                <div class="tm-avatar-container">
                                <img src="../img/avatar.png" alt="Avatar" class="tm-avatar img-fluid mb-4"/>
                                <a href="#" class="tm-avatar-delete-link"><i class="far fa-trash-alt tm-product-delete-icon"></i></a>
                                </div>
                                <!-- <button class="btn btn-primary btn-block text-uppercase">Upload New Photo</button> -->
                            </div>
                        </div>
                        <div class="tm-block-col tm-col-account-settings">
                            <div class="tm-bg-primary-dark tm-block tm-block-settings">
                                <h2 class="tm-block-title">Account Details</h2>
                                <form action="" class="tm-signup-form row" method="">
                                <div class="form-group col-lg-6">
                                    <label for="name">Id</label>
                                    <input id="id" name="id" type="text" class="form-control validate" readonly value="<?php echo $row["id"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control validate" required value="<?php echo $row["name"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="gender">Gender</label>
                                    <select id="gender" class="custom-select">
                                        <?php echo '<option value="'.$row["gender"].'">'.$row["gender"].'</option>';?>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control validate" required value="<?php echo $row["email"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="username">Username</label>
                                    <input id="username" name="username" type="text" class="form-control validate" required value="<?php echo $row["username"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" type="password" class="form-control validate" required value="<?php echo $row["password"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="password2">Re-enter Password</label>
                                    <input id="password2" name="password2" type="password" class="form-control validate" required value="<?php echo $row["password"];?>"/>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" type="tel" class="form-control validate" value="<?php echo $row["phone"];?>"/>
                                </div>
                                <?php if($row["position"]=="Admin"||$row["position"]=="Editor"){ ?>
                                <div class="form-group col-lg-6">
                                    <label for="position">Position</label>
                                    <select id="position" name="position" class="custom-select">
                                    <?php echo '<option value="'.$row["position"].'">'.$row["position"].'</option>';?>
                                        <option value="Tester">Tester</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Editor">Editor</option>
                                        <option value="Merchant">Merchant</option>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="form-group col-lg-6">
                                    <label class="tm-hide-sm">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase" name="update">Update</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <!-- https://jquery.com/download/ -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- https://getbootstrap.com/ -->
    </body>
</html>