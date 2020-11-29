<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Products</title>
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
    if($_SESSION["id"]){
      $id = $_SESSION["id"];
      $sql = "SELECT * FROM users WHERE id = '$id'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);     
    }
    else header("location: php/logout.php");
    if(isset($_SESSION["isShow"])){
      echo
      '<div class="col-12 alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>'.$_SESSION["message"].'</strong>
      </div>';
    }
    unset($_SESSION["isShow"]);
    unset($_SESSION["isIncorrect"]);
    if(isset($_POST['delete_selected'])){
      if(isset($_POST['delete'])){
        foreach($_POST['delete'] as $deleteid){
          $selectPro = "SELECT * FROM products WHERE id = ".$deleteid;
          $selectResult = mysqli_query($db,$selectPro);
          $getRow = mysqli_fetch_assoc($selectResult);
          $getIamgeName = $getRow['product_image'];
          $createDeletePath = "products/".$getIamgeName;
          if(unlink($createDeletePath)) {
            $deleteSql = "DELETE FROM products WHERE id = ".$getRow['id'];
            mysqli_query($db, $deleteSql);	
          }
          $deletePro = "DELETE FROM products WHERE id=".$deleteid;
          mysqli_query($db,$deletePro);
        }
      }
    }
  ?>
  <body id="reportsPage">
    <nav class="navbar navbar-expand-xl" style="background-color: black;">
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
                aria-expanded="false">
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
            <?php
            if($_SESSION["id"] && $row["position"] == "Admin"){
              echo 
              '<li class="nav-item">
                <a class="nav-link" href="account.php">
                  <i class="far fa-user"></i> Accounts
                </a>
              </li>';
            }
            ?>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-cog"></i>
                <span> Settings <i class="fas fa-angle-down"></i> </span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="php/updateuser.php?id=<?php echo $row["id"];?>">Profile</a>
                <a class="dropdown-item" href="#">Billing</a>
                <?php
                  if($row["position"] == "Admin" || $row["position"] == "Editor")
                  echo '<a class="dropdown-item" href="customsetting.php">Customize</a>';
                ?>
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
    <div class="container-fluit mt-5">
      <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-products">
            <form method="POST">
              <a href="addproduct.php" class="btn btn-primary btn-block text-uppercase mb-3">
                Add new product</a>
              <button class="btn btn-primary btn-block text-uppercase" type="submit" name="delete_selected">
                Delete selected products
              </button>
              <div class="tm-product-table-container">
                <table class="table table-hover tm-table-small tm-product-table">
                  <thead>
                    <tr>
                      <th scope="col">&nbsp;</th>
                      <th scope="col">ID</th>
                      <th scope="col">NAME</th>
                      <th scope="col">PRICE</th>
                      <th scope="col">IMAGE</th>
                      <th scope="col">EXP-DATE</th>
                      <th scope="col">CATEGORY</th>
                      <th scope="col">CRE-DATE</th>
                      <th scope="col">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      $lisProduct = mysqli_query($db, "SELECT * FROM products order by id");
                      while ($record = mysqli_fetch_array($lisProduct)){
                        echo
                        '<tr>
                          <th scope="row"><input type="checkbox" name="delete[]" value="'.$record["id"].'"/></th>
                          <td class="tm-product-id">'.$record["id"].'</td>
                          <td class="tm-product-name">'.$record["product_name"].'</td>
                          <td class="tm-product-name">$'.$record["product_unit"].'</td>
                          <td class="tm-product-image"><img src="products/'.$record["product_image"].'" style="width:35px;height:35px;"></td>
                          <td>'.$record["product_expired_date"].'</td>
                          <td>'.$record["product_category"].'</td>
                          <td>'.$record["created_date"].'</td>
                          <td>
                            <a href="php/deleteproduct.php?id='.$record["id"].'" class="tm-product-delete-link">
                              <i class="far fa-trash-alt tm-product-delete-icon"></i>
                            </a>
                          </td>
                          <td>
                              <a href="php/updateproduct.php?id='.$record["id"].'" class="tm-product-delete-link">
                                <i class="fas fa-pencil-alt tm-product-delete-icon"></i>
                              </a>
                            </td>
                        </tr>';
                      }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- table container -->
            </form>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-product-categories">
            <h2 class="tm-block-title">Product Categories</h2>
            <div class="tm-product-table-container">
              <table class="table tm-table-small tm-product-table">
                <tbody>
                  <?php
                    $lisCategory = mysqli_query($db, "SELECT * FROM categorys order by id");
                    while ($record = mysqli_fetch_array($lisCategory)){
                      echo
                      '<tr>
                        <td class="tm-category-name"><i class="'.$record["icon_class"].'" Style="font-size:30px;"></td>
                        <td class="tm-category-name">'.$record["category_name"].'</td>
                        <td class="text-center">
                          <a href="php/deletecategory.php?id='.$record["id"].'" class="tm-product-delete-link">
                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                          </a>
                        </td>
                      </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- table container -->
            <button type="button" class="btn btn-primary btn-block text-uppercase mb-3" data-toggle="modal" data-target="#exampleModal">
              Add new category
            </button>
          </div>
        </div>
      </div>
    </div>
    <footer class="tm-footer row tm-mt-small">
      <div class="col-12 font-weight-light">
        <p class="text-center text-white mb-0 px-4 small">
          Copyright &copy; <b>2020</b> All rights reserved.<a rel="nofollow noopener" href="https://facebook.com/reakreakms"
          class="tm-footer-link" target="_blank">reak reak</a>
        </p>
      </div>
    </footer>
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row tm-content-row">
                <div class="tm-block-col tm-col-account-settings">
                  <form action="php/addcategory.php" method="POST" class="tm-signup-form row">
                    <div class="form-group col-lg-12">
                      <label for="category_name" style="color:black;">Category Name</label>
                      <input id="category_name" name="category_name" type="text" class="form-control validate"/>
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="icon_class" style="color:black;">Category Icon(Class)</label>
                      <input id="icon-class" name="icon_class" type="text" class="form-control validate"/>
                    </div>
                    <div class="form-group col-lg-6">
                      <label class="tm-hide-sm">&nbsp;</label>
                      <button type="submit" class="btn btn-primary btn-block text-uppercase">Save Category</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
      $(function() {
        $(".tm-product-name").on("click", function() {
          window.location.href = "edit-product.html";
        });
      });
    </script>
  </body>
</html>