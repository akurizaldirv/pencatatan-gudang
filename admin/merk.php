<?php
session_start();
require '../function.php';
if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$data_provinsi = getData("SELECT 'KOTA/KAB'.NAMA_KOTA, PROVINSI.ID_PROVINSI, PROVINSI.NAMA_PROVINSI FROM MERK JOIN 'KOTA/KAB' ON MERK.ID_KOTA = 'KOTA/KAB'.ID_KOTA JOIN PROVINSI ON 'KOTA/KAB'.ID_PROVINSI = PROVINSI.ID_PROVINSI GROUP BY PROVINSI.ID_PROVINSI");
$data_idProv = [];
$data_namaProv = [];
foreach ($data_provinsi as $key) {
	$data_idProv[] = $key['ID_PROVINSI'];
	$data_namaProv[] = $key['NAMA_PROVINSI'];
}

if (isset($_GET['filterby']) and $_GET['filterby'] != "") {
	$filterby = $_GET['filterby'];
	$sortby = $_GET['sortby'];
	$sortto = $_GET['sortto'];
	$data = getData("SELECT MERK.ID_MERK, MERK.NAMA_MERK, MERK.NOTELP_MERK, MERK.EMAIL_MERK, MERK.ALAMAT, 'KOTA/KAB'.NAMA_KOTA, PROVINSI.ID_PROVINSI, PROVINSI.NAMA_PROVINSI FROM MERK JOIN 'KOTA/KAB' ON MERK.ID_KOTA = 'KOTA/KAB'.ID_KOTA JOIN PROVINSI ON 'KOTA/KAB'.ID_PROVINSI = PROVINSI.ID_PROVINSI WHERE PROVINSI.ID_PROVINSI = '$filterby' ORDER BY $sortby $sortto");
} elseif (isset($_GET['sortby'])) {
	$sortby = $_GET['sortby'];
	$sortto = $_GET['sortto'];
	$data = getData("SELECT MERK.ID_MERK, MERK.NAMA_MERK, MERK.NOTELP_MERK, MERK.EMAIL_MERK, MERK.ALAMAT, 'KOTA/KAB'.NAMA_KOTA, PROVINSI.ID_PROVINSI, PROVINSI.NAMA_PROVINSI FROM MERK JOIN 'KOTA/KAB' ON MERK.ID_KOTA = 'KOTA/KAB'.ID_KOTA JOIN PROVINSI ON 'KOTA/KAB'.ID_PROVINSI = PROVINSI.ID_PROVINSI ORDER BY $sortby $sortto");
} else {
	$data = getData("SELECT MERK.ID_MERK, MERK.NAMA_MERK, MERK.NOTELP_MERK, MERK.EMAIL_MERK, MERK.ALAMAT, 'KOTA/KAB'.NAMA_KOTA, PROVINSI.ID_PROVINSI, PROVINSI.NAMA_PROVINSI FROM MERK JOIN 'KOTA/KAB' ON MERK.ID_KOTA = 'KOTA/KAB'.ID_KOTA JOIN PROVINSI ON 'KOTA/KAB'.ID_PROVINSI = PROVINSI.ID_PROVINSI");
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
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4 text-dark fw-bold my-auto ms-5">Halaman Admin</p>
  			
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

		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Daftar Merk</h1>
			<div class="table-responsive mx-5">
				
					<table class="table">
						<tr>
							<td>
								<a href="tambahMerk.php"><button class="btn btn-warning ">
									<img src="../assets/img/add-icon.svg" width="25px" height="25px" class="me-2"> Tambah Merk</button>
								</a>
							</td>
						</tr>
						<form action="merk.php" method="get">
						<tr>
							<td>
								<label for="sortby" class="form-text">Sort by: </label>
								<select name="sortby" id="sortby" class="form-select">
									<option value="MERK.NAMA_MERK">Nama</option>
									<option value="PROVINSI.NAMA_PROVINSI">Provinsi</option>
								</select>
							</td>
							<td>
								<label for="sortto" class="form-text">Sort to: </label>
								<select name="sortto" id="sortto" class="form-select">
									<option value="ASC">Ascending</option>
									<option value="DESC">Descending</option>
								</select>
							</td>
							<td>
								<label for="filterby" class="form-text">Only Show in Province:</label>
								<select name="filterby" id="filterby" class="form-select">
									<option value="">--- Semua Provinsi ---</option>
								<?php for ($i=0; $i < count($data_idProv); $i++) : ?>
									<option value="<?= $data_idProv[$i] ?>"><?= $data_namaProv[$i] ?></option>
								<?php endfor ?>
								</select>
							</td>
							<td>
								<input type="submit" name="asd" value="Filter" class="btn btn-primary mt-4">
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="table-responsive mx-5 mt-3">
				<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th scope="col" class="table-dark">No.</th>
						<th scope="col" class="table-dark">ID</th>
						<th scope="col" class="table-dark">Nama Merk</th>
						<th scope="col" class="table-dark">Alamat</th>
						<th scope="col" class="table-dark">No. Telp</th>
						<th scope="col" class="table-dark">E-Mail</th>
						<th scope="col" class="table-dark">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php $i = 1; ?>
					<?php foreach($data as $row) :?>
					<tr>
						<td><?= $i ?></td>
						<td><?= $row['ID_MERK'] ?></td>
						<td><?= $row['NAMA_MERK'] ?></td>
						<td><?= $row['NAMA_PROVINSI']. ", " .$row['NAMA_KOTA'].", ".$row['ALAMAT'] ?></td>
						<td><?= $row['NOTELP_MERK'] ?></td>
						<td><?= $row['EMAIL_MERK'] ?></td>
						<td>
							<a href="editMerk.php?id_merk=<?= $row['ID_MERK'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px"></img></a>
							<a href="deleteMerk.php?id_merk=<?= $row['ID_MERK'] ?>" onClick="return confirm('Hapus Merk ini?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a>
						</td>
					</tr>
					<?php $i++ ?>
					<?php endforeach ?>
					</tbody>
			</table>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>