<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$id_barang = $_GET['id_barang'];
$data = getData("SELECT * FROM BARANG WHERE ID_BARANG = '$id_barang'")[0];
$data_merk = getData("SELECT * FROM MERK");
$data_kategori = getData("SELECT * FROM KATEGORI");
$daftar_warna = getData("SELECT * FROM WARNA");
$daftar_insertWarna =  getData("SELECT * FROM 'WARNA_BARANG' WHERE ID_BARANG = '$id_barang'");
$daftar_idWarna = [];
foreach ($daftar_insertWarna as $key) {
	$daftar_idWarna[] = $key['ID_WARNA'];
}

if (isset($_POST['submit'])) {
	if (editBarang($_POST)>0) {
		echo "<script>alert('Berhasil Menyunting Barang')</script>";
	} else {
		echo "<script>alert('Gagal Menyunting Barang')</script>";
	}
	echo "<script>window.location.replace('barang.php')</script>";
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
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-3 text-dark fw-bold my-auto ms-5">Halaman Admin</p>      			
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
	            <a class="nav-link text-light" href="dashboard.php">
	              Dashboard
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="pencatatan.php">
	              Daftar Pencatatan
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="merk.php">
	              Daftar Merk
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="pengirim.php">
	              Daftar Pengirim
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="kategori.php">
	              Daftar Kategori
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="warna.php">
	              Daftar Warna
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="barang.php">
	              Daftar Barang
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="profil.php">
	              Sunting Profil
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="password.php">
	              Ubah Password
	            </a>
	          </li>
	        </ul>
	      </div>
	    </nav>

	    <!-- Menu -->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
			<h1 class="h2 my-5">Edit Barang</h1>
			<div class="container w-75 py-3">
				<form method="POST" action="">
					<input type="hidden" value="<?php echo $id_barang ?>" name="id_barang">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama Barang (Tipe Sepatu)</label>
						<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['NAMA_BARANG'] ?>" required>
					</div>
					<div class="row mb-3">
						<div class="col">
							<label for="merk" class="form-label">Merk</label>
							<select class="form-select" name="merk" id="merk">
								<?php foreach ($data_merk as $merk) :?>
									<option value="<?= $merk['ID_MERK']?>" <?= ($data['ID_MERK'] == $merk['ID_MERK']) ? 'selected' : '' ?>><?=ucwords(strtolower($merk['NAMA_MERK']))?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col">
							<label for="kategori" class="form-label">Kategori</label>
							<select class="form-select" name="kategori" id="kategori">
								<?php foreach ($data_kategori as $ktg) :?>
									<option value="<?= $ktg['ID_KATEGORI']?>" <?= ($data['ID_KATEGORI'] == $ktg['ID_KATEGORI']) ? 'selected' : '' ?>><?=ucwords(strtolower($ktg['NAMA_KATEGORI']))?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="mt-3">
							<label for="warna" class="form-label">Warna yang tersedia:</label><br>
							<?php foreach ($daftar_warna as $row): ?>
							<div class="form-check form-check-inline" id="warna">
								<input class="form-check-input" type="checkbox" id="insertWarna" name="insertWarna[]" value="<?= $row['ID_WARNA'] ?>" <?= (in_array($row['ID_WARNA'], $daftar_idWarna)) ? 'checked' : '' ?>>
								<label class="form-check-label" for="insertWarna"><?= $row['NAMA_WARNA'] ?></label>
							</div>
							<?php endforeach ?>
						</div>
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary" name="submit">Sunting</button>
						<a href="barang.php"><button type="button" class="btn btn-danger" name="cancel">Batal</button></a>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>