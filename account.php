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
      if($_SESSION["id"]){
        $id = $_SESSION["id"];
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);     
      }
      if($_SESSION["id"] && $row["position"] == "Admin"){

      }else if($row["position"] != "Admin"){
        header("location: product.php");
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
      
  ?>
  <body id="reportsPage">
    <div class="" id="home">
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
                <a class="nav-link active" href="account.php">
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
                  <a class="dropdown-item" href="php/updateuser.php?id=<?php echo $row["id"];?>">Profile</a>
                  <a class="dropdown-item" href="#">Billing</a>
                  <a class="dropdown-item" href="customsetting.php">Customize</a>
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
                <!-- table container -->
                <button type="button" class="btn btn-primary btn-block text-uppercase" data-toggle="modal" data-target="#exampleModal">
                  Add new user
                </button>
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                  <div class="tm-product-table-container">
                    <table class="table table-hover tm-table-small tm-product-table">
                      <thead>
                        <tr>
                          <th scope="col">&nbsp;</th>
                          <th scope="col">ID</th>
                          <th scope="col">NAME</th>
                          <th scope="col">POSITION</th>
                          <th scope="col">USERNAME</th>
                          <th scope="col">PASSWORD</th>
                          <th scope="col">PHONE</th>
                          <th scope="col">EMAIL</th>
                          <th scope="col">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $listUser = mysqli_query($db, "SELECT * FROM users order by id");
                        while ($record = mysqli_fetch_array($listUser)) {
                          echo
                          '<tr>
                            <th scope="row"><input type="checkbox" /></th>
                            <td class="tm-product-name">'.$record["id"].'</td>
                            <td>'.$record["name"].'</td>
                            <td>'.$record["position"].'</td>
                            <td>'.$record["username"].'</td>
                            <td>'.$record["password"].'</td>
                            <td>'.$record["phone"].'</td>
                            <td>'.$record["email"].'</td>
                            <td>
                              <a href="php/deleteuser.php?id='.$record["id"].'" class="tm-product-delete-link">
                                <i class="far fa-trash-alt tm-product-delete-icon"></i>
                              </a>
                            </td>
                            <td>
                              <a href="php/updateuser.php?id='.$record["id"].'" class="tm-product-delete-link">
                                <i class="fas fa-pencil-alt tm-product-delete-icon"></i>
                              </a>
                            </td>
                          </tr>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <!-- Modal -->
      <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row tm-content-row">
                <div class="tm-block-col tm-col-avatar">
                  <div class="tm-bg-primary-dark tm-block tm-block-avatar">
                    <h2 class="tm-block-title">Change Avatar</h2>
                    <div class="tm-avatar-container">
                      <img src="img/avatar.png" alt="Avatar" class="tm-avatar img-fluid mb-4"/>
                      <a href="#" class="tm-avatar-delete-link"><i class="far fa-trash-alt tm-product-delete-icon"></i></a>
                    </div>
                    <!-- <button class="btn btn-primary btn-block text-uppercase">Upload New Photo</button> -->
                  </div>
                </div>
                <div class="tm-block-col tm-col-account-settings">
                  <div class="tm-bg-primary-dark tm-block tm-block-settings">
                    <h2 class="tm-block-title">Account Details</h2>
                    <form action="php/adduser.php" class="tm-signup-form row" method="POST">
                      <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control validate" required/>
                      </div>
                      <div class="form-group col-lg-6">
                          <label for="gender">Gender</label>
                          <select id="gender" class="custom-select">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                          </select>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-control validate" required/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control validate" required/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control validate" required/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="password2">Re-enter Password</label>
                        <input id="password2" name="password2" type="password" class="form-control validate" required/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" class="form-control validate"/>
                      </div>
                      <div class="form-group col-lg-6">
                          <label for="position">Position</label>
                          <select id="position" name="position" class="custom-select">
                            <option value="Tester">Tester</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                            <option value="Merchant">Merchant</option>
                          </select>
                      </div>
                      <div class="form-group col-lg-6">
                        <label class="tm-hide-sm">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block text-uppercase">Add</button>
                      </div>
                      <?php
                        // if($_SESSION["id"] && $row["position"] == "Admin"){
                        //   echo
                        //   '<div class="col-12">
                        //     <button
                        //       type="submit"
                        //       class="btn btn-primary btn-block text-uppercase"
                        //     >
                        //       Delete Your Account
                        //     </button>
                        //   </div>';
                        // }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  </body>
</html>
<!-- 
  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row tm-content-row">
                <div class="tm-block-col tm-col-avatar">
                  <div class="tm-bg-primary-dark tm-block tm-block-avatar">
                    <h2 class="tm-block-title">Change Avatar</h2>
                    <div class="tm-avatar-container">
                      <img src="img/avatar.png" alt="Avatar" class="tm-avatar img-fluid mb-4"/>
                      <a href="#" class="tm-avatar-delete-link"><i class="far fa-trash-alt tm-product-delete-icon"></i></a>
                    </div>
                    <button class="btn btn-primary btn-block text-uppercase">Upload New Photo</button>
                  </div>
                </div>
                <div class="tm-block-col tm-col-account-settings">
                  <div class="tm-bg-primary-dark tm-block tm-block-settings">
                    <h2 class="tm-block-title">Account Details</h2>
                    <form action="" class="tm-signup-form row">
                      <div class="form-group col-lg-6">
                        <label for="name">Account Name</label>
                        <input id="name" name="name" type="text" class="form-control validate" value="<?php echo $row["name"];?>"
                        />
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="email">Account Email</label>
                        <input id="email" name="email" type="email" class="form-control validate" value="<?php echo $row["email"]; ?>"
                        />
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control validate" value="<?php echo $row["password"]; ?>"
                        />
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="password2">Re-enter Password</label>
                        <input id="password2" name="password2" type="password" class="form-control validate" value="<?php echo $row["password"];?>"/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" class="form-control validate" value="<?php echo $row["phone"];?>"/>
                      </div>
                      <div class="form-group col-lg-6">
                        <label class="tm-hide-sm">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block text-uppercase">Update Your Profile</button>
                      </div>
                      <?php
                        // if($_SESSION["id"] && $row["position"] == "Admin"){
                        //   echo
                        //   '<div class="col-12">
                        //     <button
                        //       type="submit"
                        //       class="btn btn-primary btn-block text-uppercase"
                        //     >
                        //       Delete Your Account
                        //     </button>
                        //   </div>';
                        // }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
 -->


 
