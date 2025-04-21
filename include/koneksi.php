<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "library_management";

$koneksi = mysqli_connect($server, $user, $pass, $database);

if (!$koneksi) {
    die("<script>alert('Connection Failed.')</script>");
}

?>