<?php
session_start();
// koenksi ke database
include "koneksi.php";

// jika SESSION pelanggan belum ada (belum login), maka dikembalikan ke login.php
if (!isset($_SESSION['pelanggan'])) {
    // menampilkan Pesan harus login dahulu dengan Javascript
    echo "<script>alert('Silahkan Login Terlebih dahulu!')</script>";
    // mengarahkan ke halaman login.php secara otomatis dengan Javascript
    echo "<script>location ='login.php' </script>";
}

// jika SESSION keranjang belum ada (belum belanja), maka dikembalikan ke index.php
if (empty($_SESSION['keranjang']) or !isset($_SESSION['keranjang'])) {
    // menampilkan dengan Javascript
    echo "<script>alert('Keranjang kosong, silahkan belanja terlebih dahulu')</script>";
    // mengarahkan ke halaman index.php secara otomatis dengan Javascript
    echo "<script>location ='index.php' </script>";
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

    <?php include "menu.php" ?>

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
                    <?php $totalbelanja = 0; ?>
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
                            <td>Rp.<?php echo number_format($pecah['harga_produk']) ?></td>
                            <td><?php echo $jumlah ?></td>
                            <td>Rp.<?php echo number_format($subharga) ?></td>
                        </tr>
                        <?php $nomor++; ?>
                        <?php $totalbelanja += $subharga; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total Belanja :</th>
                        <th>Rp.<?php echo number_format($totalbelanja) ?></th>
                    </tr>
                </tfoot>

            </table>

            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" readonly class="form-control" value="<?php echo $_SESSION['pelanggan']['nama_pelanggan'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" readonly class="form-control" value="<?php echo $_SESSION['pelanggan']['telepon_pelanggan'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="id_ongkir" id="" class="form-control">
                                <option value="">Pilih Ongkos Kirim</option>
                                <?php
                                $ambil = $koneksi->query("SELECT * FROM ongkir");
                                while ($perongkir = $ambil->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $perongkir['id_ongkir'] ?>">
                                        <?php echo $perongkir['nama_kota'] ?> -
                                        Rp.<?php echo $perongkir['tarif'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap Pengiriman</label>
                    <textarea name="alamat_pengiriman" class="form-control" placeholder="masukan alamat lengkap pengiriman (termasuk kode pos)"></textarea>
                </div>
                <button class="btn btn-primary" name="checkout">Checkout</button>
            </form>

            <?php
            if (isset($_POST['checkout'])) {
                $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
                $id_ongkir = $_POST['id_ongkir'];
                $tanggal_pembelian = date("Y-m-d");

                $ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
                $arrayongkir = $ambil->fetch_assoc();
                $nama_kota = $arrayongkir['nama_kota'];
                $tarif = $arrayongkir['tarif'];

                $total_pembelian = $totalbelanja + $tarif;
                $alamat_pengiriman = $_POST['alamat_pengiriman'];

                // 1. Melakukan penyimpanan ke tabel pembelian
                $koneksi->query("INSERT INTO 
                pembelian (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian, nama_kota, tarif, alamat_pengiriman) 
                VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif','$alamat_pengiriman') ");

                // 2. Melakukan penyimpanan ke tabel pembelian_produk
                $id_pembelian_barusan = $koneksi->insert_id;

                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {

                    // Mendapatkan data produk berdasarkan id_produk
                    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                    $perproduk = $ambil->fetch_assoc();

                    $nama = $perproduk['nama_produk'];
                    $harga = $perproduk['harga_produk'];
                    $berat = $perproduk['berat_produk'];

                    $subberat = $perproduk['berat_produk'] * $jumlah;
                    $subharga = $perproduk['harga_produk'] * $jumlah;

                    $koneksi->query("INSERT INTO pembelian_produk (id_pembelian, id_produk, nama, harga, berat, subberat, subharga, jumlah) 
                    VALUES('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subberat','$subharga','$jumlah')");


                    // $koneksi->query("INSERT INTO pembelian_produk (id_pembelian, id_produk, jumlah) VALUES ('$id_pembelian_barusan','$id_produk','$jumlah') ");
                }

                // mangkosongkan keranjang
                unset($_SESSION['keranjang']);

                // menampilkan Pesan dengan Javascript
                echo "<script>alert('Pembelian sukses')</script>";
                // mengarahkan ke halaman index.php secara otomatis dengan Javascript
                echo "<script>location ='nota.php?id=$id_pembelian_barusan' </script>";
            }

            ?>
        </div>
    </section>
</body>

</html>