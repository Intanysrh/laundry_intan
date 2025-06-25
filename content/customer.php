<?php
include 'config/koneksi.php';

$queryCustomer = mysqli_query($config,  "SELECT * FROM customer ORDER BY id DESC");
$rowCustomers = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id =  $_GET['delete']; // untuk mengambil nilai parameter
    //masukin $query untuk melakukan perintah yg diinginkan 
    $delete  = mysqli_query($config, "DELETE FROM customer WHERE id = '$id'");
    header("location:?page=customer&hapus=berhasil");
}
?>

<!DOCTYPE html>
<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

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

    <title>Customer</title>

    <meta name="description" content="" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">Customer</div>
                                <div class="card-body">
                                    <?php if (isset($_GET['delete'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Your data has been deleted
                                        </div>
                                    <?php endif ?>
                                    <div align="right" class="mb-3">
                                        <a href="?page=tambah-customer" class="btn btn-primary">Add</a>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Customer's Name</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($rowCustomers as $data) { ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data['customer_name'] ?></td>
                                                    <td><?php echo $data['phone'] ?></td>
                                                    <td><?php echo $data['address'] ?></td>
                                                    <td>
                                                        <a href="?page=tambah-customer&edit=<?php echo $data['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                                        <a onclick="return confirm ('Are you sure?')" href="?page=customer&delete=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Delete</a>
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

</body>

</html>