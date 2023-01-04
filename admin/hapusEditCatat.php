<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$id = $_GET['id'];
$id2 = $_GET['id2'];
$id3 = $_GET['id3'];
$id4 = $_GET['id4'];
$id_faktur = $_GET['id_faktur'];
// var_dump($id_faktur);
$data_temp = $_SESSION['tempCatat'];
var_dump($id);
var_dump($id2);
var_dump($id3);
var_dump($id4);
var_dump($data_temp);

for ($i=1; $i < count($data_temp)+1; $i++) { 
    if ($id == $data_temp[$i][1] and $id2 == $data_temp[$i][2] and $id3 == $data_temp[$i][3] and $id4 == $data_temp[$i][4]) {
        unset($data_temp[$i]);
    }
}

$_SESSION['tempCatat'] = $data_temp;
header("Location:	editFaktur.php?id_faktur=$id_faktur");
?>