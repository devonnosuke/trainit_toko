<?php include 'koneksi.php';

$keyword = $_GET['keyword'];
$semuadata = [];

$ambil = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'");
while ($pecah = $ambil->fetch_assoc()) {
    $semuadata[] = $pecah;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>
    <?php include 'menu.php' ?>

    <div class="container">
        <h3>Hasil Pencarian : <?php echo $keyword ?></h3>
        <?php if (empty($semuadata)) : ?>
            <div class="alert alert-danger">Produk <strong><?php echo $keyword ?></strong> tidak ditemukan</div>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($semuadata as $key => $value) : ?>
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="foto_produk/<?php echo $value['foto_produk'] ?>" class="img-responsive">
                        <div class="caption">
                            <h3><?php echo $value['nama_produk'] ?></h3>
                            <h5>Rp.<?php echo number_format($value['harga_produk']) ?></h5>
                            <a href="beli.php?id=<?php echo $value['id_produk'] ?>" class="btn btn-primary">Beli</a>
                            <a href="detail.php?id=<?php echo $value['id_produk'] ?>" class="btn btn-default">detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>