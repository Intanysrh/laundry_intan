<?php
// cara pak reza
if (isset($_POST['simpan'])) {
    $id_customer = $_POST['id_customer'];
    $no_transaksi = $_POST['order_code'];
    $tanggal_laundry = $_POST['order_date'];

    $id_paket = $_POST['id_service'];
    $qty = $_POST['qty'];

    // insert ke table trans_order
    $insert =  mysqli_query($koneksi, "INSERT INTO trans_order (id_customer, order_code, order_date) VALUES ('$id_customer','$no_transaksi', '$tanggal_laundry')");

    $last_id = mysqli_insert_id($koneksi);
    // insert ke table trans_order_detail
    foreach ($id_paket as $key => $value) {

        // $id_paket = array_filter($_POST['id_service']);
        // $qty = array_filter($_POST['qty']);
        if (!empty($value) && !empty($qty[$key]) && (int)$qty[$key] > 0) {
            $id_service = $value; // Current service ID
            $quantity = (int)$qty[$key]; // Current quantity

            // Query to get the price from table type_of_service
            $queryPaket = mysqli_query($koneksi, "SELECT price FROM type_of_service WHERE id='$id_service'");
            if ($rowPaketTransc = mysqli_fetch_assoc($queryPaket)) {
                $harga = $rowPaketTransc['price'];
                $subTotal = $quantity * $harga;

                // Insert into trans_order_detail
                $insertDetailTransaksi = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES ('$last_id', '$id_service', '$quantity', '$subTotal')");
            }
        }
    }
}
