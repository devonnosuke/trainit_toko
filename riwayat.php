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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>

    <?php include "menu.php" ?>

    <div class="riwayat">
        <div class="container">
            <h3>Riwayat Belanja <?php echo $_SESSION['pelanggan']['nama_pelanggan'] ?></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>Status</td>
                        <td>Total</td>
                        <td>Opsi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    // mendapatkan id_pelanggan yg login dari session
                    $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

                    $ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan'");

                    while ($pecah = $ambil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $nomor ?></td>
                            <td><?php echo $pecah['tanggal_pembelian'] ?></td>
                            <td>
                                <?php echo $pecah['status_pembelian'] ?><br>
                                <?php if (!empty($pecah['resi_pengiriman'])) : ?>
                                    Resi: <?php echo $pecah['resi_pengiriman']; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo number_format($pecah['total_pembelian']) ?></td>
                            <td>
                                <a href="nota.php?id=<?php echo $pecah['id_pembelian'] ?>" class="btn btn-info">Nota</a>
                                <a href="pembayaran.php?id=<?php echo $pecah['id_pembelian'] ?>" class="btn btn-success">Pembayaran</a>
                            </td>
                        </tr>
                        <?php $nomor++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>