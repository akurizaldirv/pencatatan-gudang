<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

$data_kategori = getData("SELECT KATEGORI.NAMA_KATEGORI, KATEGORI.ID_KATEGORI FROM BARANG JOIN KATEGORI ON KATEGORI.ID_KATEGORI = BARANG.ID_KATEGORI GROUP BY KATEGORI.ID_KATEGORI");
$data_idKtg = [];
$data_namaKtg = [];
foreach ($data_kategori as $key) {
	$data_idKtg[] = $key['ID_KATEGORI'];
	$data_namaKtg[] = $key['NAMA_KATEGORI'];
}

$data_merk = getData("SELECT MERK.ID_MERK, MERK.NAMA_MERK FROM BARANG JOIN MERK ON MERK.ID_MERK = BARANG.ID_MERK GROUP BY MERK.ID_MERK");
$data_idMerk = [];
$data_namaMerk = [];
foreach ($data_merk as $key) {
	$data_idMerk[] = $key['ID_MERK'];
	$data_namaMerk[] = $key['NAMA_MERK'];
}

$query = "SELECT BARANG.ID_BARANG, BARANG.NAMA_BARANG, BARANG.ID_MERK, BARANG.ID_KATEGORI, MERK.NAMA_MERK, KATEGORI.NAMA_KATEGORI FROM BARANG JOIN MERK ON BARANG.ID_MERK = MERK.ID_MERK JOIN KATEGORI ON BARANG.ID_KATEGORI = KATEGORI.ID_KATEGORI";

if (isset($_GET['filter'])) {
	$sortby = $_GET['sortby'];
	$sortto = $_GET['sortto'];
	$a = "";
	$b = "";
	if (isset($_GET['filterbyKtg']) and $_GET['filterbyKtg'] != "") {
		$filterbyKtg = $_GET['filterbyKtg'];
		$a = "KATEGORI.ID_KATEGORI = '$filterbyKtg'";
	}
	if (isset($_GET['filterbyMerk']) and $_GET['filterbyMerk'] != "") {
		$filterbyMerk = $_GET['filterbyMerk'];
		$b = "MERK.ID_MERK = '$filterbyMerk'";
	}
	if ($a != "" and $b != "") {
		$query .= " WHERE " .$a. " AND " .$b;
	} elseif ($a != "" or $b != "") {
		$query .= " WHERE " .$a. " " .$b;
	}
	$query .= " ORDER BY ". $sortby. " " .$sortto. " ";
}
$data = getData($query);
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
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Daftar Barang</h1>
				<div class="table-responsive mx-5">
					<table class="table">
						<tr>
							<td>
								<a href="tambahBarang.php"><button class="btn btn-warning ">
									<img src="../assets/img/add-icon.svg" width="25px" height="25px" class="me-2"> Tambah Barang</button>
								</a>
							</td>
						</tr>
						<form action="barang.php" method="get">
						<tr>
							<td>
								<label for="sortby" class="form-text">Sort by: </label>
								<select name="sortby" id="sortby" class="form-select">
									<option value="MERK.NAMA_MERK">Merk</option>
									<option value="KATEGORI.NAMA_KATEGORI">Kategori</option>
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
								<label for="filterbyKtg" class="form-text">Only Show in Kategori:</label>
								<select name="filterbyKtg" id="filterbyKtg" class="form-select">
									<option value="">--- Semua Kategori ---</option>
								<?php for ($i=0; $i < count($data_idKtg); $i++) : ?>
									<option value="<?= $data_idKtg[$i] ?>"><?= $data_namaKtg[$i] ?></option>
								<?php endfor ?>
								</select>
							</td>
							<td>
								<label for="filterbyMerk" class="form-text">Only Show in Merk:</label>
								<select name="filterbyMerk" id="filterbyMerk" class="form-select">
									<option value="">--- Semua Merk ---</option>
								<?php for ($i=0; $i < count($data_idMerk); $i++) : ?>
									<option value="<?= $data_idMerk[$i] ?>"><?= $data_namaMerk[$i] ?></option>
								<?php endfor ?>
								</select>
							</td>
							<td>
								<input type="submit" name="filter" value="Filter" class="btn btn-primary mt-4">
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
						<th scope="col" class="table-dark">Merk</th>
						<th scope="col" class="table-dark">Tipe</th>
						<th scope="col" class="table-dark">Warna</th>
						<th scope="col" class="table-dark">Kategori</th>
						<th scope="col" class="table-dark">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php $i = 1; ?>
					<?php foreach($data as $row) :?>
					<tr>
						<td><?= $i ?></td>
						<td><?= $row['ID_BARANG'] ?></td>
						<?php
							$daftar_warna = "";
							$id_barang = $row['ID_BARANG'];
							$warna = getData("SELECT WARNA.NAMA_WARNA FROM WARNA INNER JOIN WARNA_BARANG WHERE WARNA.ID_WARNA = WARNA_BARANG.ID_WARNA AND WARNA_BARANG.ID_BARANG = '$id_barang'");
							foreach ($warna as $key) {
								$daftar_warna .= $key['NAMA_WARNA']. ", ";
							}
						?>
						<td><?= $row['NAMA_MERK'] ?></td>
						<td><?= $row['NAMA_BARANG'] ?></td>
						<td><?= substr($daftar_warna, 0, -2) ?></td>
						<td><?= $row['NAMA_KATEGORI'] ?></td>
						<td>
							<a href="editBarang.php?id_barang=<?= $row['ID_BARANG'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px"></img></a>
							<a href="deleteBarang.php?id_barang=<?= $row['ID_BARANG'] ?>" onClick="return confirm('Hapus Data Pengirim ini?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a>
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