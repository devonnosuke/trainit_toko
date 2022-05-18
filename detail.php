<?php

session_start();

// mendapatkan id yang dikirim di url
$id_produk = $_GET['id'];

// koneksi
include "koneksi.php";

// query ke db
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$pecah = $ambil->fetch_assoc();
?>
<pre><?php print_r($pecah) ?></pre>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
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

    <section class="konten">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="foto_produk/<?php echo $pecah['foto_produk'] ?>" class="img-responsive">
                </div>
                <div class="col-md-6">
                    <h2><?php echo $pecah['nama_produk'] ?></h2>
                    <h4>Rp.<?php echo $pecah['harga_produk'] ?></h4>

                    <form method="POST">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="1" class="form-control" name="jumlah">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" name="beli">Beli</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    // jk ada tombol beli
                    if (isset($_POST['beli'])) {
                        // mendapatkan jumlah yang diinputkan
                        $jumlah = $_POST['jumlah'];
                        // masukan di keranjang belanja
                        $_SESSION['keranjang'][$id_produk] = $jumlah;

                        // menampilkan Pesan dengan Javascript
                        echo "<script>alert('produk telah masuk ke keranjang belanja')</script>";
                        // mengarahkan ke halaman keranjang.php secara otomatis dengan Javascript
                        echo "<script>location ='keranjang.php' </script>";
                    }
                    ?>

                    <p><?php echo $pecah['deskripsi_produk'] ?></p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>