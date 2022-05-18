<?php
// koenksi ke database
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>

    <?php include "menu.php" ?>

    <section class="konten">
        <div class="container">
            <!-- nota disisni copas saja dari nota yang ada di admin -->
            <h2>Detail Pembelian</h2>
            <?php
            $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.id_pembelian ='$_GET[id]'");
            $detail = $ambil->fetch_assoc();
            ?>

            <div class="row">
                <div class="col-md-4">
                    <h3>Pembelian</h3>
                    <strong>No. Pembelian: <?php echo $detail['id_pembelian'] ?></strong><br>
                    Tanggal: <?php echo $detail['tanggal_pembelian'] ?><br>
                    Total: Rp.<?php echo number_format($detail['total_pembelian']) ?>
                </div>
                <div class="col-md-4">
                    <h3>Pelanggan</h3>
                    <strong><?php echo $detail['nama_pelanggan'] ?></strong><br>
                    <p>
                        <?php echo $detail['telepon_pelanggan'] ?><br>
                        <?php echo $detail['email_pelanggan'] ?>
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Pengiriman</h3>
                    <strong><?php echo $detail['nama_kota'] ?></strong><br>
                    Ongkos Kirim: Rp.<?php echo number_format($detail['tarif']) ?><br>
                    Alamat: <?php echo $detail['alamat_pengiriman'] ?>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>no</th>
                        <th>nama produk</th>
                        <th>harga</th>
                        <th>berat</th>
                        <th>jumlah</th>
                        <th>sub berat</th>
                        <th>sub total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'") ?>
                    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $nomor ?></td>
                            <td><?php echo $pecah['nama']; ?></td>
                            <td>Rp.<?php echo number_format($pecah['harga']); ?></td>
                            <td><?php echo $pecah['berat']; ?> Gr.</td>
                            <td><?php echo $pecah['jumlah']; ?></td>
                            <td><?php echo $pecah['subberat']; ?> Gr.</td>
                            <td>Rp.<?php echo number_format($pecah['subharga']); ?></td>
                        </tr>
                        <?php $nomor++ ?>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-7">
                    <div class="alert alert-info">
                        <p>
                            Silahkan melakukan pembayaran Rp.<?php echo number_format($detail['total_pembelian']) ?> <br>
                            <strong>BANK MANDIRI 137-001088-3276 AN.Arif Nur Rohman</strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</body>

</html>