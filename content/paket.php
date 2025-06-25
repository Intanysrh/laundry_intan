<?php
session_start();
include 'koneksi.php';

$queryPaket = mysqli_query($koneksi,  "SELECT * FROM type_of_service ORDER BY id DESC");
if (isset($_GET['delete'])) {
    $id =  $_GET['delete'];
    $delete  = mysqli_query($koneksi, "DELETE FROM type_of_service WHERE id = '$id'");
    header("location:paket.php?hapus=berhasil");
}

?>


<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Paket</title>

    <meta name="description" content="" />

    <?php include 'inc/head.php'; ?>

</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'inc/sidebar.php'; ?>
            <div class="layout-page">
                <?php include 'inc/nav.php'; ?>

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">Paket</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil dihapus
                                            </div>
                                        <?php endif ?>
                                        <div align="right" class="mb-3">
                                            <a href="tambah-paket.php" class="btn btn-primary">Tambah</a>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Paket</th>
                                                    <th>Harga</th>
                                                    <th>Deskripsi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                while ($rowPaket = mysqli_fetch_assoc($queryPaket)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowPaket['service_name'] ?></td>
                                                        <td><?php echo "Rp" . number_format($rowPaket['price']) ?></td>
                                                        <td><?php echo $rowPaket['description'] ?></td>
                                                        <td>
                                                            <a href="tambah-paket.php?edit=<?php echo $rowPaket['id'] ?>" class="btn btn-success btn-sm">
                                                                <span class="tf-icon bx bx-pencil bx-18px"></span></a>
                                                            <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                                                href="paket.php?delete=<?php echo $rowPaket['id'] ?>" class="btn btn-danger btn-sm">
                                                                <span class="tf-icon bx bx-trash bx-18px"></span></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</body>

</html>