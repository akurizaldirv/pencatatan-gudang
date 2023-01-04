<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL001')){
	header("Location:	logout.php");
};
$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
	$pass = getData("SELECT PASSWORD FROM ADMIN WHERE USERNAME = '$username'")[0]['PASSWORD'];

    if (base64_encode($_POST['passlama']) == $pass) {
		if (changePass($_POST)>0) {
			echo "<script>alert('Berhasil Mengubah Password')</script>";
		} else {
			echo "<script>alert('Gagal Mengubah Password')</script>";
		}
    } else {
		echo "<script>alert('Password Lama Salah')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.sidebar{
			height: 100vh;
			position: fixed;
		}
	</style>
</head>
<body>
<header class="navbar fixed-top bg-warning flex-md-nowrap shadow-lg py-2">
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-3 text-dark fw-bold my-auto ms-5">Halaman Super Admin</p>      			
  		<div class="nav">
    		<span class="nav-item text-nowrap my-auto fs-5">Selamat Datang, <b><?php echo $_SESSION['username'] ?>!</b></span>
    		<div class="nav-item text-nowrap">
      			<a class="nav-link mx-5" href="logout.php"><button class="btn btn-danger">Sign out</button></a>
    		</div>
  		</div>
	</header>

	<div class="container-fluid">
	  <div class="row">

	  	<!-- Sidebar -->
	    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
	      <div class="position-sticky pt-3 sidebar-sticky pt-5">
	        <ul class="nav flex-column mt-5">
	          <li class="nav-item">
	            <a class="nav-link text-light" href="admin.php">
	              Daftar Admin
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="profil.php">
	              Sunting Profil
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="password.php">
	              Ubah Password
	            </a>
	          </li>
	        </ul>
	      </div>
	    </nav>
 
		<!-- Menu -->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Ubah Password</h1>
			<div class="container w-50 pt-3">
				<form method="POST" action="">
					<input type="hidden" name="username" value="<?php echo $username ?>">
					<div class="mb-3">
						<label for="passlama" class="form-label">Password Lama</label>
						<input type="password" class="form-control" id="passlama" name="passlama" placeholder="Masukkan Password Lama">
					</div>
					<div class="mb-3">
						<label for="passbaru" class="form-label">Password Baru</label>
						<input type="password" class="form-control" id="passbaru" name="passbaru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" placeholder="Masukkan Password Baru" required>
						<div class="form-text"><i>** Password harus mengandung kombinasi antara huruf kecil, huruf besar, dan angka.</i></div>
					</div>
					<div class="mb-3">
						<label for="verpassbaru" class="form-label">Verifikasi Password Baru</label>
						<input type="password" class="form-control" id="verpassbaru" name="verpassbaru" onKeyUp="validatePassword()" placeholder="Masukkan Kembali Password Baru" required>
						<div class="form-text"><i>** Verifikasi Password harus sesuai dengan Password Baru.</i></div>
					</div>
					<div class="mb-3">
						<button type="submit" name="submit" class="btn btn-primary" onClick="validatePassword()">Submit</button>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>

	<script>
		function validatePassword(){
			var pass1 = document.getElementById('passbaru').value;
			var pass2 = document.getElementById('verpassbaru').value;
			if (pass1 != pass2){
				document.getElementById('verpassbaru').setCustomValidity('Verification Password does not match');
			} else {
				document.getElementById('verpassbaru').setCustomValidity('');
			}
		}
	</script>
</body>
</html>