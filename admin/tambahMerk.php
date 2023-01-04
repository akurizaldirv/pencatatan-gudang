<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

$daftar_provinsi = getData("SELECT * FROM PROVINSI  ORDER BY ID_PROVINSI");
$daftar_kota = getData("SELECT * FROM 'KOTA/KAB' ORDER BY ID_PROVINSI");

if (isset($_POST['submit'])) {
	if (tambahMerk($_POST)>0) {
		echo "<script>alert('Berhasil Menambah Merk')</script>";
	} else {
		echo "<script>alert('Gagal Menambah Merk')</script>";
	}
	echo "<script>window.location.replace('merk.php')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="merk.php">
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
	            <a class="nav-link text-light" href="barang.php">
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

		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
			<h1 class="h2 my-5">Tambah Merk</h1>
			<div class="container w-75 py-3">
				<form method="post" action="">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama Merk</label>
						<input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama Merk" required>
					</div>
					<div class="col mb-3">
						<div class="row">
							<label for="provinsi" class="form-label">Alamat:</label>
						</div>
						<div class="row">
							<div class="col">
								<select class="form-select" name="provinsi" id="provinsi">
								<?php foreach ($daftar_provinsi as $prov) :?>
									<option value="<?= $prov['ID_PROVINSI']?>"><?=ucwords(strtolower($prov['NAMA_PROVINSI']))?></option>
								<?php endforeach ?>
								</select>
								<div class="form-text"><em>Provinsi</em></div>
							</div>
							<div class="col">
								<select class="form-select" name="kabupaten" id="kabupaten"></select>
								<div class="form-text"><em>Kabupaten/Kota</em></div>
							</div>
						</div>
						<div class="mt-3">
							<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat Lengkap" required>
							<div class="form-text"><em>Alamat Lengkap</em></div>
						</div>
						
					</div>
					<div class="mb-4">
						<label for="email" class="form-label">E-Mail</label>
						<input type="email" class="form-control" name="email" id="email" required placeholder="Masukkan E-Mail">
					</div>
					<div class="mb-4">
						<label for="notelp" class="form-label">No. Telepon</label>
						<input type="text" class="form-control" id="notelp" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Nomor Telepon" name="notelp">
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary" name="submit">Tambah</button>
						<a href="merk.php"><button type="button" class="btn btn-danger" name="cancel">Batal</button></a>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
	<script>
		$("#provinsi").click(function(){
			var id_provinsi = $("#provinsi").val();
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "ambil-data.php",
				data: "provinsi="+id_provinsi,
				success: function(data){
					$("#kabupaten").html(data);
				}
			});
		});
	</script>
</body>
</html>