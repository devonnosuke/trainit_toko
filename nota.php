<?php
// koenksi ke database
include "koneksi.php";
session_start();
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

            <!-- jika pelanggan yang beli tidak sama dengan pelanggan yang login, maka dilarikan ke riwayat.php karena tidak berhak melihat nota orang lain -->
            <?php
            // mendapatkan id_pelanggan
            $idpelangganyangbeli = $detail['id_pelanggan'];

            // mendapatkan id pelanggan yang login
            $idpelangganyanglogin = $_SESSION['pelanggan']['id_pelanggan'];

            if ($idpelangganyangbeli !== $idpelangganyanglogin) {
                // menampilkan Pesan dengan Javascript
                echo "<script>alert('jangan nakal')</script>";
                // mengarahkan ke halaman riwayat.php secara otomatis dengan Javascript
                echo "<script>location ='riwayat.php' </script>";
                exit();
            }
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
                    Ongkos Kirim: <b>Rp.<?php echo number_format($detail['tarif']) ?></b><br>
                    Alamat: <b><?php echo $detail['alamat_pengiriman'] ?></b>
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
                    <?php $nomor = 1;
                    $totalbelanja = 0; ?>
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
                        <?php $totalbelanja += $pecah['subharga']; ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">Total Belanja (Ditambah Ongkir) : </th>
                        <th>Rp.<?php echo number_format($totalbelanja) ?> + Rp.<?php echo number_format($detail['tarif']) ?> = Rp.<?php echo number_format($detail['total_pembelian']) ?></th>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="id_ongkir" id="pilih" class="form-control" onchange="ubahRekening()">
                            <option value="">Pilih Bank Terlebih Dahulu</option>
                            <option value="137-647582-2834 AN.Arif Nur Rohman">BANK MANDIRI</option>
                            <option value="124-312312-2837 AN.MUFASA">BANK BRI</option>
                            <option value="123-231954-4756 AN.HAKUNA MATATA">BANK BNI</option>
                            <option value="452-787856-1275 AN.GROOFY">BANK BSI</option>
                            <option value="127-364612-3423 AN.ARNOLD">BANK BCA</option>
                            <option value="456-907865-8898 AN.DOLOR SIT AMET">BANK BUKOPIN</option>
                            <option value="986-556342-3423 AN.LOREM IPSUM">BANK OCBCNISP</option>
                            <option value="453-124323-3422 AN.ARA">BANK MEGA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8" id="kolom" style="display:none">
                    <div class="alert alert-info">
                        <p>
                            Silahkan melakukan pembayaran sebesar <b>Rp.<?php echo number_format($detail['total_pembelian']) ?></b> <br>
                            Ke <strong id="tampil"></strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <script>
        const pilih = document.getElementById('pilih');
        const tampil = document.getElementById('tampil');
        const kolom = document.getElementById('kolom');

        function ubahRekening() {
            kolom.style = 'display:block';
            tampil.textContent = pilih.value;
        }
        console.log(pilih);
    </script>
</body>

</html>