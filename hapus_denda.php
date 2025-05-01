<?php  
require_once "include/koneksi.php";
session_start();

$id = $_GET['id'];

  	$sql2 = "DELETE FROM denda WHERE id = '$id'";

	if (mysqli_query($koneksi, $sql2)) {
		header('location:tbl_denda.php');
	} 


?>