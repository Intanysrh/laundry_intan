<?php
include 'config/koneksi.php';

if (isset($_POST['save'])) {
    $name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $insert =  mysqli_query($config, "INSERT INTO customer (customer_name, phone, address) VALUES ('$name', '$phone', '$address')");
    header("location:?page=customer&tambah=berhasil");
}

$id  = isset($_GET['edit']) ?  $_GET['edit'] : '';
$editCustomer = mysqli_query($config, "SELECT * FROM customer WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($editCustomer);

if (isset($_POST['edit'])) {
    $name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $update = mysqli_query($config, "UPDATE customer SET customer_name='$name', phone='$phone', address='$address' WHERE id = '$id'");
    header("location:customer.php?ubah=berhasil");
}
?>

<!DOCTYPE html>
<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Customer</title>
</head>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Customer</div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="form-label">Customer's Name</label>
                                    <input type="text" class="form-control" id="" name="customer_name" placeholder="Insert customer's name" required
                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['customer_name'] : '' ?>">
                                </div>

                                <div class="col-sm-6">
                                    <label for="" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" id="" name="phone" placeholder="Insert customer's phone number" required
                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['phone'] : '' ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Address</label>
                                    <textarea type="text" name="address" class="form-control" id="" col="15" rows="5"><?php echo isset($_GET['edit']) ? $rowEdit['address'] : '' ?></textarea>
                                </div>

                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'save' ?>" type="submit">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</html>