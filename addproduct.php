<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Add Product - Dashboard HTML Template</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:400,700"
    />
    <!-- https://fonts.google.com/specimen/Roboto -->
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="jquery-ui-datepicker/jquery-ui.min.css" type="text/css" />
    <!-- http://api.jqueryui.com/datepicker/ -->
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
      if($_SESSION["id"]){
        $id = $_SESSION["id"];
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);     
      }
      // INSERT INTO `products` (`id`, `product_name`, `product_image`, `created_date`, `product_unit`, `product_expired_date`, `product_description`, `product_category`)
      // VALUES (NULL, '', '', '', '', '', '')
      else header("location: php/logout.php");
      if (isset($_POST['upload'])) {
        // Get image name
        $product_image = $_FILES['product_image']['name'];
        // Get text
        $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
        $product_unit = mysqli_real_escape_string($db, $_POST['product_unit']);
        $product_expired_date = mysqli_real_escape_string($db, $_POST['product_expired_date']);
        $product_description= mysqli_real_escape_string($db, $_POST['product_description']);
        $product_category = mysqli_real_escape_string($db, $_POST['product_category']);
        $created_by = mysqli_real_escape_string($db,$_SESSION["id"]);
        $sql = "INSERT INTO products (product_name, product_image, created_by, product_unit, product_expired_date, product_description, product_category)
        VALUES ('$product_name', '$product_image', '$created_by','$product_unit', '$product_expired_date','$product_description','$product_category')";
        // execute query
        $message = "";
        if($product_image!=null){
            // image file directory
            $target = "products/".basename($product_image);
            mysqli_query($db, $sql) or die(mysqli_error($db));
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target)) {
                $message = "upload successfully";
            }else{
              $message = "Failed to upload image";
            }
        }
        else{
            $message = "No image select found =".$sql;
        }
        $_SESSION["isShow"] = true;
        $_SESSION["message"] = $message;
        header("location: product.php");
      }
  ?>
  <body>
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
              <a class="nav-link active" href="product.php">
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
                class="nav-link dropdown-toggle"
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
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Billing</a>
                <a class="dropdown-item" href="#">Customize</a>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link d-block" href="login.html">
                Admin, <b>Logout</b>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12">
                <h2 class="tm-block-title d-inline-block">Add Product</h2>
              </div>
            </div>
            <div class="row tm-edit-product-row">
              <div class="col-xl-6 col-lg-6 col-md-12">
                <form action="" class="tm-edit-product-form" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="name">Product Name</label>
                    <input id="name" name="product_name" type="text" class="form-control validate" required/>
                  </div>
                  <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control validate" rows="3" name="product_description" required></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label for="category">Category</label>
                    <select class="custom-select tm-select-accounts" id="category" name="product_category">
                    <?php
                      $lisCategory = mysqli_query($db, "SELECT * FROM categorys");
                      while ($record = mysqli_fetch_array($lisCategory)){
                        echo '<option value="'.$record["category_name"].'">'.$record["category_name"].'</option>';
                      }
                    ?>
                    </select>
                  </div>
                  <div class="row">
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label for="expire_date">Expire Date</label>
                          <input id="expire_date" name="product_expired_date" type="text" class="form-control validate" data-large-mode="true"/>
                        </div>
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label for="stock">Units In Stock</label>
                          <input id="stock" name="product_unit" type="text" class="form-control validate" required/>
                        </div>
                  </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                <div class="tm-product-img-dummy mx-auto">
                  <div class="pre-img" style="width:100%;height:100%;margin:auto;text-align:center;">
                    <img id="image" style="height:100%;"/>
                  </div>
                  <input type="hidden" name="size" value="1000000">
                </div>
                <div class="custom-file mt-3 mb-3">
                  <input id="fileInput" type="file" style="display:none;" name="product_image" onchange="loadFile()"/>
                  <input type="button" class="btn btn-primary btn-block mx-auto" value="UPLOAD PRODUCT IMAGE" onclick="document.getElementById('fileInput').click();"/>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" name="upload" class="btn btn-primary btn-block text-uppercase">Add Product Now</button>
              </div>
            </form>
            <div class="col-12">
              <a class="btn btn-primary btn-block text-uppercase" href="product.php">Cancel</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="tm-footer row tm-mt-small">
        <div class="col-12 font-weight-light">
          <p class="text-center text-white mb-0 px-4 small">
            Copyright &copy; <b>2018</b> All rights reserved. 
            Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
        </p>
        </div>
    </footer> 

    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="jquery-ui-datepicker/jquery-ui.min.js"></script>
    <!-- https://jqueryui.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
      function loadFile(){
			  var image = document.getElementById('image');
		    image.src = URL.createObjectURL(event.target.files[0]);
      }
      $(function() {
        $("#expire_date").datepicker();
      });
    </script>
  </body>
</html>
