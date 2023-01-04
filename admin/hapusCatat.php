<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$id = $_GET['id'];
$data_temp = $_SESSION['tempCatat'];

for ($i=0; $i < count($data_temp); $i++) { 
    if ($id == $data_temp[$i][1]) {
        unset($data_temp[$i]);
    }
}

$_SESSION['tempCatat'] = $data_temp;
header("Location:	catat.php");
?>