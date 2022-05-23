<?php
$dataKategori = [];

$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
    $dataKategori[] = $tiap;
}

?>
<h2>Tambah Produk</h2>

<form method="POST" enctype="multipart/form-data" style="text-transform: capitalize ;">
    <div class="form-group">
        <label>nama</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>kategori</label>
        <select name="id_kategori" class="form-control">
            <option value="">pilih kategori</option>
            <?php foreach ($dataKategori as $key => $value) : ?>
                <option value="<?php echo $value['id_kategori'] ?>"><?php echo $value['nama_kategori'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Harga (Rp.)</label>
        <input type="number" class="form-control" name="harga">
    </div>
    <div class="form-group">
        <label>Berat (Gr)</label>
        <input type="number" class="form-control" name="berat">
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <div style="margin-bottom:10px;" id="letak">
            <input type="file" class="form-control" name="foto[]">
        </div>
        <span class="btn btn-primary" onclick="tambahField()" id="button">
            <i class="fa fa-plus"></i>
        </span>
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
    $namanamafoto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    move_uploaded_file($lokasi[0], "../foto_produk/" . $namanamafoto[0]);

    $koneksi->query("INSERT INTO produk
     (nama_produk,harga_produk,berat_produk,foto_produk,deskripsi_produk,id_kategori)
    VALUES('$_POST[nama]','$_POST[harga]','$_POST[berat]','$namanamafoto[0]','$_POST[deskripsi]','$_POST[id_kategori]')");

    // Mendapatkan id terbaru 
    $id_terbaru = $koneksi->insert_id;

    foreach ($namanamafoto as $key => $tiap_nama) {
        $tiap_lokasi = $lokasi[$key];
        move_uploaded_file($tiap_lokasi, "../foto_produk/'.$tiap_nama");

        $koneksi->query("INSERT INTO produk_foto (id_produk,nama_foto_produk) VALUES('$id_terbaru','$tiap_nama')");
    }

    echo "<script>alert('Data Produk Berhasil Ditambah!')</script>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";
}
?>
<script src="assets/js/jquery-1.10.2.js"></script>
<script>
    $(document).ready(function() {
        $("#button").on("click", function() {
            $("#letak").append('<input type="file" class="form-control" name="foto[]">');
        })
    })
</script>