<h2>Ubah Produk</h2>
<?php

$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]' ");
$pecah = $ambil->fetch_assoc();

$dataKategori = [];

$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
    $dataKategori[] = $tiap;
}

?>

<pre><?php print_r($pecah) ?></pre>

<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>nama</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $pecah['nama_produk'] ?>">
    </div>
    <div class="form-group">
        <label>kategori</label>
        <select name="id_kategori" class="form-control">
            <option value="">pilih kategori</option>
            <?php foreach ($dataKategori as $key => $value) : ?>
                <option value="<?php echo $value['id_kategori'] ?>" <?= ($pecah['id_kategori'] == $value['id_kategori']) ? 'selected' : '' ?>>
                    <?php echo $value['nama_kategori'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Harga (Rp)</label>
        <input type="number" class="form-control" name="harga" value="<?php echo $pecah['harga_produk'] ?>">
    </div>
    <div class="form-group">
        <label>Berat (Gr)</label>
        <input type="number" class="form-control" name="berat" value="<?php echo $pecah['berat_produk'] ?>">
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="10"><?php echo $pecah['deskripsi_produk'] ?></textarea>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto">
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
if (isset($_POST['ubah'])) {
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    // jk foto diubah

    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "../foto_produk/" . $namafoto);

        $koneksi->query("UPDATE produk 
        SET
         nama_produk='$_POST[nama]',
         id_kategori='$_POST[id_kategori]',
         harga_produk='$_POST[harga]',
         berat_produk='$_POST[berat]',
         foto_produk='$namafoto',
         deskripsi_produk='$_POST[deskripsi]'
         WHERE id_produk='$_GET[id]'
        ");
    } else {
        $koneksi->query("UPDATE produk 
        SET
         nama_produk='$_POST[nama]',
         id_kategori='$_POST[id_kategori]',
         harga_produk='$_POST[harga]',
         berat_produk='$_POST[berat]',
         deskripsi_produk='$_POST[deskripsi]'
         WHERE id_produk='$_GET[id]'
        ");
    }


    echo "<script>alert('Data Produk Berhasil Diubah!')</script>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";
}
?>