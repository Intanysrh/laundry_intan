<?php
include 'config/koneksi.php';

// Fetch all services from the database
$queryService = mysqli_query($config, "SELECT * FROM type_of_service ORDER BY id DESC");
$rowService = mysqli_fetch_all($queryService, MYSQLI_ASSOC);

// Handle deletion of a service
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM type_of_service WHERE id = '$id'");
    header("location:?page=service&hapus=berhasil");
    exit; // Ensure no further code is executed after redirect
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Service</title>
    <meta name="description" content="" />
    <?php include 'inc/header.php'; ?>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'inc/sidebar.php'; ?>
            <div class="layout-page">

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">Service</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Data successfully deleted
                                            </div>
                                        <?php endif; ?>
                                        <div align="right" class="mb-3">
                                            <a href="?page=tambah-service" class="btn btn-primary">Add Service</a>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($rowService as $key => $service) { ?>
                                                    <tr>
                                                        <td><?php echo $key += 1 ?></td>
                                                        <td><?php echo $service['service_name'] ?></td>
                                                        <td><?php echo "Rp" . number_format($service['price']) ?></td>
                                                        <td><?php echo $service['description'] ?></td>
                                                        <td>
                                                            <a href="?page=tambah-service&edit=<?php echo $service['id'] ?>" class="btn btn-success btn-sm">
                                                                <span class="tf-icon bx bx-pencil bx-18px">Edit</span></a>
                                                            <a onclick="return confirm('Are you sure you want to delete this data?')"
                                                                href="?page=service&delete=<?php echo $service['id'] ?>" class="btn btn-danger btn-sm">
                                                                <span class="tf-icon bx bx-trash bx-18px">Hapus</span></a>
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>