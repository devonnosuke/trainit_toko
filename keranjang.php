<?php
session_start();
// koenksi ke database
$koneksi = new mysqli("localhost", "root", "", "trainittoko");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang belanja</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="keranjang.php">Keranjang</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten -->
    <section class="konten">
        <div class="container">
            <h1>Keranjang Belanja</h1>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>NO</td>
                        <td>Produk</td>
                        <td>Harga</td>
                        <td>Jumlah</td>
                        <td>SubHarga</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) : ?>
                        <!-- menampilkan produk yg sedang diperulangkan berdasarkan id_produk -->
                        <?php
                        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                        $pecah = $ambil->fetch_assoc();
                        $subharga = $pecah['harga_produk'] * $jumlah;
                        ?>
                        <tr>
                            <td><?php echo $nomor ?></td>
                            <td><?php echo $pecah['nama_produk'] ?></td>
                            <td><?php echo number_format($pecah['harga_produk']) ?></td>
                            <td><?php echo $jumlah ?></td>
                            <td><?php echo number_format($subharga) ?></td>
                        </tr>
                        <?php $nomor++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
            <a href="checkout.php" class="btn btn-primary">Checkout</a>
        </div>
    </section>
    <script src="admin/assets/js/bootstrap.min.js"></script>
</body>

</html>