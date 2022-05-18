<?php
session_start();
// koenksi ke database
include "koneksi.php";

// jika SESSION pelanggan belum ada (belum belanja), maka dikembalikan ke index.php
if (empty($_SESSION['pelanggan']) or !isset($_SESSION['pelanggan'])) {
    // menampilkan dengan Javascript
    echo "<script>alert('silahkan login')</script>";
    // mengarahkan ke halaman login.php secara otomatis dengan Javascript
    echo "<script>location ='login.php' </script>";
    exit();
}

// mendapatkan id_pembelian dari url
$idpem = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
$detpem = $ambil->fetch_assoc();

// mndapatkan id_pelanggan yg beli
$id_pelanggan_beli = $detpem['id_pelanggan'];
// mndapatkan id_pelanggan yg login
$id_pelanggan_login = $_SESSION['pelanggan']['id_pelanggan'];

if ($id_pelanggan_login !== $id_pelanggan_beli) {
    // menampilkan dengan Javascript
    echo "<script>alert('jangan nakal')</script>";
    // mengarahkan ke halaman riwayat.php secara otomatis dengan Javascript
    echo "<script>location ='riwayat.php' </script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>
    <?php include "menu.php" ?>
    <div class="container">
        <h2>Konfirmasi Pembayaran</h2>
        <p>Kirim bukti pembayaran Anda disini</p>
        <div class="alert alert-info">
            Total tagihan anda <strong>Rp.<?php echo number_format($detpem['total_pembelian']) ?></strong>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Penyetor</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="form-group">
                <label>Bank</label>
                <input type="text" class="form-control" name="bank">
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" class="form-control" name="jumlah" min="1">
            </div>
            <div class="form-group">
                <label>Foto Bukti</label>
                <input type="file" class="form-control" name="bukti">
            </div>
            <button class="btn btn-primary" name="kirim">Kirim</button>
        </form>
    </div>

    <?php

    // jika tombol kirim di klik
    if (isset($_POST['kirim'])) {
        // upload dulu foto bukti
        $namabukti = $_FILES['bukti']['name'];
        $lokasibukti = $_FILES['bukti']['tmp_name'];
        $namafiks = date("YmdHis") . $namabukti;
        move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafiks");

        $nama = $_POST['nama'];
        $bank = $_POST['bank'];
        $jumlah = $_POST['jumlah'];
        $tanggal = date("Y-m-d");

        // simpan pembayaran
        $koneksi->query("INSERT INTO pembayaran(id_pembelian, nama, bank, jumlah, tanggal, bukti)
        VALUES ('$idpem','$nama','$bank','$jumlah','$tanggal','$namafiks')");

        // update data pembelian dari pending ke sudah dikirim pembayaran
        $koneksi->query("UPDATE pembelian SET status_pembelian='sudah melakukan pembayaran' WHERE id_pembelian='$idpem'");

        // menampilkan dengan Javascript
        echo "<script>alert('Terimakasih sudah mengirimkan bukti pembayaran')</script>";
        // mengarahkan ke halaman riwayat.php secara otomatis dengan Javascript
        echo "<script>location ='riwayat.php' </script>";
    }
    ?>
</body>

</html>