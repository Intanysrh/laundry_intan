<?php
if (isset($_GET['delete'])) {
    $id_service = isset($_GET['delete']) ? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "UPDATE type_of_service SET deleted_at=1 WHERE id = $id_service");
    if ($queryDelete) {
        header("location:?page=service&hapus=berhasil");
    } else {
        header("location:?page=service&hapus=gagal");
    }
}

if (isset($_POST['service_name'])) {
    // jika ada parameter bernama edit, maka jalankan perintah edit/update. Kalo tidak ada, mnaka tambahkan data baru/insert.
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $id_service = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO type_of_service (service_name, price, description) VALUES('$service_name','$price','$description')");
        header("location:?page=service&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE type_of_service SET service_name = '$service_name', price = '$price', description = '$description' WHERE id = '$id_service'");
        // print_r($update);
        // die;
        header("location:?page=service&ubah=berhasil");
    }
}

if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $id = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM type_of_service WHERE id = $id");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
} else {
    $rowEdit = []; // atau bisa diatur sesuai kebutuhan
}




?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Service</title>
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
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Service</div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6 mb-3">
                                                    <label for="service_name" class="form-label">Service Name</label>
                                                    <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter Service Name" required
                                                        value="<?php echo isset($rowEdit['service_name']) ? $rowEdit['service_name'] : '' ?>">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required
                                                        value="<?php echo isset($rowEdit['price']) ? $rowEdit['price'] : '' ?>">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" id="description" cols="15" rows="5"><?php echo isset($rowEdit['description']) ? $rowEdit['description'] : '' ?></textarea>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary" name="<?php echo isset($rowEdit) ? 'edit' : 'simpan' ?>" type="submit">Save</button>
                                            </div>
                                        </form>
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