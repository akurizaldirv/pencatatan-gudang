<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

if ($_SESSION['tempFaktur'] == "") {
	$_SESSION['tempFaktur'] = $_GET['id_faktur'];
}
$id_faktur = $_SESSION['tempFaktur'];
if($_SESSION['tempPengirim'] == ""){
	$_SESSION['tempPengirim'] = getData("SELECT * FROM FAKTUR WHERE ID_FAKTUR = '$id_faktur'")[0]['ID_PENGIRIM'];
}
$id_pengirim = $_SESSION['tempPengirim'];
$dataCatat = getData("SELECT * FROM PENCATATAN WHERE ID_FAKTUR = '$id_faktur'");
if ($_SESSION['tempCatat'] == []) {
    foreach ($dataCatat as $key) {
        $id_barang = $key['ID_BARANG'];
        $tempMerk = getData("SELECT * FROM BARANG WHERE ID_BARANG = '$id_barang'")[0]['ID_MERK'];
        $_SESSION['tempCatat'][] = array($tempMerk, $id_barang, $key['ID_WARNA'], $key['UKURAN'], $key['JUMLAH']);
    }
}

$daftar_merk = getData("SELECT MERK.ID_MERK, MERK.NAMA_MERK FROM MERK INNER JOIN PENGIRIM_MERK WHERE MERK.ID_MERK = PENGIRIM_MERK.ID_MERK AND PENGIRIM_MERK.ID_PENGIRIM = '$id_pengirim'");
$data_temp = $_SESSION['tempCatat'];

if (isset($_POST['tambah'])) {
    $_SESSION['tempCatat'][] = array($_POST['merk'], $_POST['barang'], $_POST['warna'], $_POST['ukuran'], $_POST['jml']);
    header("Location:	editFaktur.php");
}
if (isset($_POST['submit'])) {
    if (editCatat($_SESSION['tempCatat'], $_SESSION['tempPengirim'], $_SESSION['username'], $id_faktur)) {
        echo "<script>alert('Berhasil Menyunting Pencatatan')</script>";
    } else {
        echo "<script>alert('Gagal Menyunting Pencatatan')</script>";
    }
    echo "<script>window.location.replace('pencatatan.php')</script>";
}
if (isset($_POST['tambahPengirim'])) {
    $_SESSION['tempPengirim'] = $id_pengirim;
    echo "<script>alert('Berhasil Menyimpan Pengirim')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Font Awesome icons (free version)-->
    <!-- <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script> -->

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
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="pencatatan.php">
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

	    <!-- Menu -->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5 mx-5">Catat Detail Barang</h1>
			<table class="table table-sm ms-5">
				<tr>
					<form action="" method="post">
						<td>
							<select class="form-select" name="merk" id="merk" required>
							<?php foreach ($daftar_merk as $row) :?>
								<option value="<?= $row['ID_MERK']?>"><?=ucwords(strtolower($row['NAMA_MERK']))?></option>
							<?php endforeach ?>
							</select>
							<div class="form-text"><em>Merk</em></div>
						</td>
						<td>
							<select name="barang" id="barang" class="form-select" required></select>
							<div class="form-text"><em>Tipe</em></div>
						</td>
						<td>
							<select name="warna" id="warna" class="form-select" required></select>
							<div class="form-text"><em>Warna</em></div>
						</td>
						<td>
							<div class="input-group">
								<span class="input-group-text">EU</span>
								<select name="ukuran" id="ukuran" class="form-select" required>
									<?php for ($i=32; $i <= 45; $i++) { 
										echo "<option value='$i'>$i</option>";
									} ?>
								</select>  
							</div>
							<div class="form-text"><em>Ukuran</em></div>
						</td>
						<td>
							<input type="number" name="jml" id="jml" class="form-control" required>
							<div class="form-text"><em>Jumlah</em></div>
						</td>
						<td><button name="tambah" id="tambah" type="submit" class="btn btn-warning mb-4">Tambah</button></td>
					</form>
				</tr>
			</table>
			<form action="" method="POST">
			<div class="table-responsive mx-5 mt-3">
				<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th scope="col" class="table-dark">Merk</th>
						<th scope="col" class="table-dark">Tipe</th>
						<th scope="col" class="table-dark">Warna</th>
						<th scope="col" class="table-dark">Ukuran</th>
						<th scope="col" class="table-dark">Jumlah (pcs)</th>
						<th scope="col" class="table-dark">Action</th>
					</tr>
				</thead>
				<tbody class="show_item">
					<?php foreach($data_temp as $row) :?>
					<tr>
						<td><?= $row[0] ?></td>
						<td><?= $row[1] ?></td>
						<td><?= $row[2] ?></td>
						<td><?= $row[3] ?></td>
						<td><?= $row[4] ?></td>
						<td><a href="hapusEditCatat.php?id=<?= $row['1'] ?>&id2=<?= $row['2'] ?>&id3=<?= $row['3'] ?>&id4=<?= $row['4'] ?>&id_faktur=<?php echo $id_faktur ?>" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a></td>
					</tr>
					<?php endforeach ?>
						<tr>
							<td colspan="5"><div class="form-text ms-4"><em>* Silahkan tekan tombol catat, jika selesai memasukkan daftar detail barang.<br> ** Merk, Tipe Barang, dan Ukuran tidak boleh sama.</em></div></td>
							<td><input type="submit" value="Catat" name="submit" class="btn btn-primary"></td>
						</tr>
					</form>
				</tbody>
			</table>
			</div>
		</main>
	  </div>
	</div>
	<script>
		$("#merk").click(function(){
			var id_merk = $("#merk").val();
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "ambil-data.php",
				data: "merk="+id_merk,
				success: function(data){
					$("#barang").html(data);
				}
			});
		});
		
		$("#barang").click(function(){
			var id_barang = $("#barang").val();
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "ambil-data.php",
				data: "barang="+id_barang,
				success: function(data){
					$("#warna").html(data);
				}
			});
		});
	</script>
</body>
</html>