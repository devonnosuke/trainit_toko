<?php

$id_produk = $_GET['id'];

$ambil = $koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori WHERE produk.id_produk='$id_produk'");
$detailproduk = $ambil->fetch_assoc();

$fotoproduk = [];
$ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk='$id_produk'");
while ($tiapfoto = $ambilfoto->fetch_assoc()) {
    $fotoproduk[] = $tiapfoto;
}
?>
<table class="table">
    <tr>
        <th>Nama</th>
        <td><?php echo $detailproduk['nama_produk'] ?></td>
    </tr>
    <tr>
        <th>kategori</th>
        <td><?php echo $detailproduk['nama_kategori'] ?></td>
    </tr>
    <tr>
        <th>harga</th>
        <td>Rp.<?php echo number_format($detailproduk['harga_produk']) ?></td>
    </tr>
    <tr>
        <th>berat</th>
        <td><?php echo $detailproduk['berat_produk'] ?></td>
    </tr>
    <tr>
        <th>deskripsi</th>
        <td><?php echo $detailproduk['deskripsi_produk'] ?></td>
    </tr>
    <tr>
        <th>stok</th>
        <td><?php echo $detailproduk['stok_produk'] ?></td>
    </tr>
</table>

<div class="row">
    <?php foreach ($fotoproduk as $key => $value) : ?>
        <div class="col-md-3 text-center">
            <img src="../foto_produk/<?php echo $value['nama_foto_produk'] ?>" class="img-responsive">
            <a href="index.php?halaman=hapusfotoproduk&idfoto=<?php echo $value['id_produk_foto'] ?>&idproduk=<?php echo $value['id_produk'] ?>" class="btn btn-danger btn-sm">Hapus</a>
        </div>
    <?php endforeach; ?>
</div>

<br>

<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>File Foto</label>
        <input type="file" name="fotomu">
    </div>
    <button class="btn btn-primary" name="simpan">Simpan</button>
</form>

<?php

if (isset($_POST['simpan'])) {
    $lokasifoto = $_FILES['fotomu']['tmp_name'];
    $namafoto = $_FILES['fotomu']['name'];

    $namafoto = date("YmdHis") . $namafoto;

    move_uploaded_file($lokasifoto, '../foto_produk/' . $namafoto);
    $koneksi->query("INSERT INTO produk_foto (id_produk,nama_foto_produk) VALUES ('$id_produk','$namafoto') ");

    // menampilkan Pesan Gagal telah logout dengan Javascript
    echo "<script>alert('foto produk disimpan')</script>";
    // mengarahkan ke halaman index.php secara otomatis dengan Javascript
    echo "<script>location ='index.php?halaman=detailproduk&id=$id_produk' </script>";
}
?>