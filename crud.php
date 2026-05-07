<?php
include 'koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// =======================
// CREATE
// =======================
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $sandi = $_POST['sandi'];

    mysqli_query($koneksi, "INSERT INTO users (nama, sandi) VALUES ('$nama', '$sandi')");

    header("Location: index.php");
    exit;
}

// =======================
// UPDATE
// =======================
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $sandi = $_POST['sandi'];

    mysqli_query($koneksi, "UPDATE users SET 
        nama='$nama',
        sandi='$sandi'
        WHERE id='$id'
    ");

    header("Location: index.php");
    exit;
}

// =======================
// DELETE
// =======================
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    header("Location: index.php");
    exit;
}

// =======================
// READ
// =======================
$data = mysqli_query($koneksi, "SELECT * FROM users");
?>
