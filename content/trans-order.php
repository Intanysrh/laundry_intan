<?php
include 'config/koneksi.php';
// munculkan atau pilih  sebuah atau semua kolom dari table user
$queryTrans = mysqli_query($config,  "SELECT customer.customer_name, trans_order.* FROM trans_order LEFT JOIN customer ON customer.id=trans_order.id_customer ORDER BY id DESC");
// pake mysqli_fetch_assoc($query) = untuk menjadikan hasil query menjadi sebuah data (object, array)
// $dataUser = mysqli_fetch_assoc($queryUser);
// jika parameternya ada ?delete=nilai parameter
if (isset($_GET['delete'])) {
    $id =  $_GET['delete']; // untuk mengambil nilai parameter
    //masukin $query untuk melakukan perintah yg diinginkan
    $delete  = mysqli_query($config, "DELETE FROM trans_order WHERE id = '$id'");
    header("location:?page=trans-order&hapus=berhasil");
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

    <title>Transaction Data</title>

    <meta name="description" content="" />

    <?php include 'inc/header.php'; ?>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include 'inc/sidebar.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">Transaction</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Data has been deleted
                                            </div>
                                        <?php endif ?>
                                        <div align="right" class="mb-3">
                                            <a href="?page=tambah-trans" class="btn btn-primary">Add</a>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>No Invoice</th>
                                                    <th>Customer Name</th>
                                                    <th>Laundry Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                while ($rowTrans = mysqli_fetch_assoc($queryTrans)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowTrans['order_code'] ?></td>
                                                        <td><?php echo $rowTrans['customer_name'] ?></td>
                                                        <td><?php echo $rowTrans['order_date'] ?></td>
                                                        <td><?php echo $rowTrans['total'] ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($rowTrans['order_status']) {
                                                                case '1':
                                                                    $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
                                                                    break;
                                                                default:
                                                                    $badge = "<span class='badge bg-warning'>Baru</span>";
                                                                    break;
                                                            }
                                                            echo $badge;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="?page=tambah-trans&detail=<?php echo $rowTrans['id'] ?>" class="btn btn-primary btn-sm">
                                                                <span class="tf-icon bx bx-show bx-18px"></span> Order
                                                            </a>
                                                            <a target="_blank" href="?page=print&id=<?php echo $rowTrans['id'] ?>" class="btn btn-success btn-sm">
                                                                <span class="tf-icon bx bx-printer bx-18px"></span> Print
                                                            </a>
                                                            <a onclick="return confirm('Are you sure to delete this data?')"
                                                                href="?page=trans-order&delete=<?php echo $rowTrans['id'] ?>" class="btn btn-danger btn-sm">
                                                                <span class="tf-icon bx bx-trash bx-18px"></span>Delete</a>
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
                    <script>
                        const button = document.querySelector('#addRow');
                        const tbody = document.querySelector('#myTable tbody');
                        let count = 0;

                        button.addEventListener("click", function() {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
        <td>
            <select name="id_service[]" class="form-control" required>
                <option value="">Choose Service</option>
                <?php foreach ($rowsS as $key => $data) { ?>
                    <option value="<?php echo $data['id']; ?>"><?php echo $data['service_name']; ?></option>
                <?php } ?>
            </select>
        </td>
        <td><input type="number" step="any" class="form-control" name="qty[]" placeholder="Enter your quantity" required></td>
        <td><textarea class="form-control" name="notes[]"></textarea></td>
        
        <td><button type="button" class="btn btn-danger delRow">Delete</button></td>
        `;
                            tbody.appendChild(tr);

                        });

                        // Delegasi event ke tbody
                        tbody.addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('delRow')) {
                                const tr = e.target.closest('tr');
                                if (tr) {
                                    tr.remove(); // Hapus baris
                                }
                            }
                        });

                        function name(params) {

                        }
                    </script>

</body>

</html>