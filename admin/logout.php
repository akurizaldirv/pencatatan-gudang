<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
?>
<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("Location:   ../index.php");
exit;
?>