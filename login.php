<?php
session_start();
// koenksi ke database
include "koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="keranjang.php">Keranjang</a></li>
                <?php if (isset($_SESSION['pelanggan'])) : ?>
                    <!-- Jika telah login tampilkan menu di bawah -->
                    <li><a href="logout.php">Logout</a></li>
                <?php else : ?>
                    <!-- Jika belum login tampilkan menu di bawah -->
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login Pelanggan</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button class="btn btn-primary" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php

// jika tombol login di-klik maka jalankan kode di dalam if
if (isset($_POST["login"])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Melakukan Query cek akun di tabel pelanggan di db
    $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");

    // Hitung akun yang cocok dengan hasil inputan user
    $akunyangcocok = $ambil->num_rows;

    // jika ada akun yang cocok 1 akun maka jalankan kode di dalam if
    if ($akunyangcocok == 1) {
        // jika akun cocok dengan di database, simpan data pelanggan ke dalam SESSION
        // 1. mengambil data pelanggan di database dan disimpan ke variabel $akun
        $akun = $ambil->fetch_assoc();
        // 2. setelah data di atas didapatkan, simpan isi variabel $akun ke dalam SESSION
        $_SESSION['pelanggan'] = $akun;

        // menampilkan Pesan Gagal login dengan Javascript
        echo "<script>alert('yey, anda berhasil login')</script>";
        // mengarahkan ke halaman login.php secara otomatis dengan Javascript
        echo "<script>location ='checkout.php' </script>";
    } else {
        // jika akun tidak ada yang cocok di database

        // menampilkan Pesan Gagal login dengan Javascript
        echo "<script>alert('anda gagal login, periksa akun Anda')</script>";
        // mengarahkan ke halaman login.php secara otomatis dengan Javascript
        echo "<script>location ='login.php' </script>";
    }
}
?>