<?php
session_start();
if (isset($_SESSION['login'])) {
  if ($_SESSION['level'] == 'LVL001') {
    header("Location: super admin/admin.php");
  }elseif ($_SESSION['level'] == 'LVL002') {
    header("Location: admin/dashboard.php");
  }
}
require 'function.php';
if(isset($_POST['submit'])){
  $user = strtolower($_POST['username']);
  $pass = base64_encode($_POST['password']);
  $passCheck = getData("SELECT * FROM ADMIN WHERE USERNAME = '$user'");
  if(count($passCheck)>0){
    if($pass == $passCheck[0]['PASSWORD']){
      if ($passCheck[0]['ID_LEVEL'] == 'LVL001') {
        $_SESSION['login'] = true;
        $_SESSION['level'] = 'LVL001';
        $_SESSION['username'] = $passCheck[0]['USERNAME'];
        header("Location: super admin/admin.php");
      } elseif ($passCheck[0]['ID_LEVEL'] == 'LVL002'){
        header("Location: admin/dashboard.php");
        $_SESSION['login'] = true;
        $_SESSION['level'] = 'LVL002';
        $_SESSION['username'] = $passCheck[0]['USERNAME'];
      }
    } else {
      echo "<script>alert('Password salah')</script>";
    }    
  } else {
    echo "<script>alert('Username tidak ditemukan')</script>";    
  }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pencatatan Gudang Sepatu</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    
  

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      body{
      	background-color: white;
      }

      .heroes {
   		height: 700px;
      	background-image: url("assets/img/bgsepatu.jpg");
      	background-size: cover;
      	padding-top: 200px;
      }

      .container-form-login{
      	height: 350px;
      	margin: 200px auto;
      	padding: 25px;
      	border-radius: 25px;
      }
    </style>

  </head>
  <body>
    <div class="text-center heroes">
      <h1 class="display-5 fw-bold text-warning">Sistem Pencatatan Gudang Sepatu</h1>
      <div class="col-lg-6 mx-auto text-light">
        <p class="lead mb-4">Aplikasi ini dibuat untuk mencatat data sepatu yang masuk di gudang XYZ</p>
        <div class="d-grid justify-content-sm-center">
          <a href="#form"><button type="button" class="btn btn-primary btn-lg px-4">Mulai</button></a>
        </div>
      </div>
    </div>

    <div class="w-25 container-form-login bg-light border border-primary">
      <h3 class="mb-3">Silahkan Masuk!</h3>
    <form id="form" method="post" action="">
      <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" >
      </div>
      <button type="submit" name="submit" class="btn btn-primary my-3">Masuk</button>
    </form>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>