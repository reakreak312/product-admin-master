<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Accounts</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:400,700"
    />
    <!-- https://fonts.google.com/specimen/Roboto -->
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="css/templatemo-style.css">
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
  </head>
  <?php 
        include('php/connection.php'); 
        session_start();
        unset($_SESSION["message"]);
        if($_SESSION["id"]){
            $id = $_SESSION["id"];
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($db,$sql);
            $row1 = mysqli_fetch_array($result,MYSQLI_ASSOC);     
        }
        if($_SESSION["id"] && ($row1["position"] == "Admin" || $row1["position"] == "Editor")){

        }else if($row["position"] != "Admin"){
            header("location: product.php");
        }
        else header("location: php/logout.php");
        $sql2 = "SELECT * FROM settings LIMIT 1";
        $result2 = mysqli_query($db,$sql2);
        $row = mysqli_fetch_array($result2,MYSQLI_ASSOC); 
        if(isset($_POST['update'])){
            //update
            $logo = $_FILES['logo']['name'];
            $location = mysqli_real_escape_string($db,$_POST['location']);
            $email = mysqli_real_escape_string($db,$_POST['email']); 
            $phone = mysqli_real_escape_string($db,$_POST['phone']); 
            $aboutus = mysqli_real_escape_string($db,$_POST['aboutus']); 
            $fb = mysqli_real_escape_string($db,$_POST['fb']);
            $yt = mysqli_real_escape_string($db,$_POST['yt']);
            $tg = mysqli_real_escape_string($db,$_POST['tg']);
            $ig = mysqli_real_escape_string($db,$_POST['ig']);

            if($logo != ""){
                //remove old image from folder
                $removeImg = "SELECT logo FROM settings WHERE id = 1";
                $selectResult = mysqli_query($db,$removeImg);
                $getRow = mysqli_fetch_assoc($selectResult);
                $count = mysqli_num_rows($result);
                if($count == 1) {
                    $getIamgeName = $getRow['logo'];
                    $createDeletePath = "products/".$getIamgeName;
                    unlink($createDeletePath);
                }
                // image file directory
                $target = "products/".basename($logo);
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                    $message = "move image successfully";
                }else{
                    $message = "failed to move image";
                }
            $sql = "UPDATE settings SET location='$location',email='$email',phone='$phone',aboutus='$aboutus',fb='$fb',yt='$yt',tg='$tg',ig='$ig',logo='$logo' WHERE id=1"; 
            }
            else $sql = "UPDATE settings SET location='$location',email='$email',phone='$phone',aboutus='$aboutus',fb='$fb',yt='$yt',tg='$tg',ig='$ig' WHERE id=1"; 
            $message = "";
            if ($db->query($sql) === TRUE) {
                $message = "Website updated successfully";
            } 
            else {
                $message .= "Error updating record: " . $db->error;
            }
            echo
            '<div class="col-12 alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>'.$message.'</strong>
            </div>';
            echo "<meta http-equiv='refresh' content='0'>";
        }
        // if(isset($_POST['delete_selected'])){
        //     if(isset($_POST['delete'])){
        //       foreach($_POST['delete'] as $deleteid){
        //         $selectPro = "SELECT * FROM products WHERE id = ".$deleteid;
        //         $selectResult = mysqli_query($db,$selectPro);
        //         $getRow = mysqli_fetch_assoc($selectResult);
        //         $getIamgeName = $getRow['product_image'];
        //         $createDeletePath = "products/".$getIamgeName;
        //         if(unlink($createDeletePath)) {
        //           $deleteSql = "DELETE FROM products WHERE id = ".$getRow['id'];
        //           mysqli_query($db, $deleteSql);	
        //         }
        //         $deletePro = "DELETE FROM products WHERE id=".$deleteid;
        //         mysqli_query($db,$deletePro);
        //     }
        // }
  ?>
  <body id="reportsPage">
    <div class="" id="home">
        <nav class="navbar navbar-expand-xl">
            <div class="container h-100">
            <a class="navbar-brand" href="index.html">
                <h1 class="tm-site-title mb-0">Product Admin</h1>
            </a>
            <button
                class="navbar-toggler ml-auto mr-0"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars tm-nav-icon"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto h-100">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                    <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    <i class="far fa-file-alt"></i>
                    <span> Reports <i class="fas fa-angle-down"></i> </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Daily Report</a>
                    <a class="dropdown-item" href="#">Weekly Report</a>
                    <a class="dropdown-item" href="#">Yearly Report</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php">
                    <i class="fas fa-shopping-cart"></i> Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="account.php">
                    <i class="far fa-user"></i> Accounts
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a
                    class="nav-link dropdown-toggle active"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    <i class="fas fa-cog"></i>
                    <span> Settings <i class="fas fa-angle-down"></i> </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="php/updateuser.php?id=<?php echo $row["id"];?>">Profile</a>
                    <a class="dropdown-item" href="#">Billing</a>
                    <a class="dropdown-item active" href="#">Customize</a>
                    </div>
                </li>
                </ul>
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link d-block" href="php/logout.php">
                    Admin, <b>Logout</b>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="container mt-5">
                <div class="row tm-content-row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                        <div class="row tm-content-row">
                            <div class="tm-block-col tm-col-avatar">
                                <div class="tm-bg-primary-dark tm-block tm-block-avatar">
                                    <h2 class="tm-block-title">Change New Logo</h2>
                                    <div class="tm-avatar-container" style="width:100%;height:100%;margin:auto;text-align:center;">
                                        <img id="image" alt="logo" class="tm-avatar img-fluid mb-4" style="height:100%;" src="products/<?php echo $row["logo"];?>"/>
                                        <!-- <a href="#" class="tm-avatar-delete-link"><i class="far fa-trash-alt tm-product-delete-icon"></i></a> -->
                                        <input type="hidden" name="size" value="1000000">
                                    </div>
                                    <button class="btn btn-primary btn-block text-uppercase" onclick="document.getElementById('fileInput').click();">Upload New Logo</button>
                                </div>
                            </div>
                            <div class="tm-block-col tm-col-account-settings">
                                <div class="tm-bg-primary-dark tm-block tm-block-settings">
                                    <h2 class="tm-block-title">Website Details</h2>
                                    <form action="" class="tm-signup-form row" method="POST" enctype="multipart/form-data">
                                        <input id="fileInput" type="file" style="display:none;" name="logo" onchange="loadFile()"/>
                                        <h4 class="col-lg-12 tm-block-title">Address</h4>
                                        <div class="form-group col-lg-6">
                                            <label for="location">Location</label>
                                            <input id="location" name="location" type="text" class="form-control validate" value="<?php echo $row["location"];?>"
                                            />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="email">Email</label>
                                            <input id="email" name="email" type="email" class="form-control validate" value="<?php echo $row["email"]; ?>"
                                            />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="phone">Phone</label>
                                            <input id="phone" name="phone" type="text" class="form-control validate" value="<?php echo $row["phone"]; ?>"
                                            />
                                        </div>
                                        <h4 class="col-lg-12 tm-block-title">Follow Us</h4>
                                        <div class="form-group col-lg-6">
                                            <label for="fb">Facebook</label>
                                            <input id="fb" name="fb" type="text" placeholder="url ex:https://web.facebook.com/username" class="form-control validate" value="<?php echo $row["fb"];?>"/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="tg">Telegram</label>
                                            <input id="tg" name="tg" type="text" placeholder="url ex:https://t.me/username" class="form-control validate" value="<?php echo $row["tg"];?>"/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="ig">Instagram</label>
                                            <input id="ig" name="ig" type="text" placeholder="url" class="form-control validate" value="<?php echo $row["ig"];?>"/>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="yt">YouTube</label>
                                            <input id="yt" name="yt" type="text" placeholder="url" class="form-control validate" value="<?php echo $row["yt"];?>"/>
                                        </div>
                                        <h4 class="col-lg-12 tm-block-title">About Us</h4>
                                        <div class="form-group col-lg-12">
                                            <textarea id="aboutus" class="form-control validate" rows="3" name="aboutus" value="<?php echo $row["aboutus"];?>"></textarea>
                                        </div>
                                        <label class="tm-hide-sm">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase" name="update">Update Your Website</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="tm-footer row tm-mt-small">
            <div class="col-12 font-weight-light">
            <p class="text-center text-white mb-0 px-4 small">
                Copyright &copy; <b>2020</b> All rights reserved. 
                <a rel="nofollow noopener" href="https://facebook.com/reakreakms" target="_blanl" class="tm-footer-link">reak reak</a>
            </p>
            </div>
        </footer>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
        function loadFile(){
            var image = document.getElementById('image');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
  </body>
</html>