<?php
session_start();
// koenksi ke database
$koneksi = new mysqli("localhost", "root", "", "trainittoko");

// jika SESSION pelanggan belum ada (belum login), maka dikembalikan ke login.php
if (!isset($_SESSION['pelanggan'])) {
    // menampilkan Pesan harus login dahulu dengan Javascript
    echo "<script>alert('Silahkan Login Terlebih dahulu!')</script>";
    // mengarahkan ke halaman login.php secara otomatis dengan Javascript
    echo "<script>location ='login.php' </script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="keranjang.php">Keranjang</a></li>
                <!-- Jika telah login tampilkan menu di bawah -->
                <?php if (!empty($_SESSION['pelanggan'])) : ?>
                    <li><a href="logout.php">Logout</a></li>
                    <!-- Jika belum login tampilkan menu di bawah -->
                <?php else : ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
        </div>
    </nav>
    <pre><?php print_r($_SESSION['pelanggan']) ?></pre>
</body>

</html>