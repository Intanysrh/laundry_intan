<?php
// Include the database connection file
include 'config/koneksi.php';

// Generate order code
$queryO = mysqli_query($config, "SELECT id FROM trans_order ORDER BY id DESC LIMIT 1"); // Optimized to fetch only the last ID
if (mysqli_num_rows($queryO) == 0) {
    $code_form = "INTAN#" . "1";
} else {
    $rowO = mysqli_fetch_assoc($queryO);
    // Ensure $rowO['id'] is treated as an integer before addition
    $code_form = "INTAN#" . ((int)$rowO['id'] + 1);
}

// Fetch all customers that are not deleted
$queryC = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL ORDER BY id DESC");
$rowsC = mysqli_fetch_all($queryC, MYSQLI_ASSOC);

// Fetch all types of service that are not deleted for the "Add Row" functionality
$queryService = mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at IS NULL");
$rowService = mysqli_fetch_all($queryService, MYSQLI_ASSOC); // Corrected variable name from $rowsS to $rowService

// Handle form submission
if (isset($_POST['save'])) {
    // Sanitize and get main order data
    $order_code = htmlspecialchars($_POST['order_code']);
    $id_customer = (int)$_POST['id_customer'];
    $order_date = htmlspecialchars($_POST['order_date']);
    $order_end_date = htmlspecialchars($_POST['order_end_date']);
    $order_status = (int)$_POST['order_status'];

    // Initialize total amount
    $total_amount = 0;

    // Start transaction to ensure data consistency
    mysqli_begin_transaction($config);

    try {
        // Insert into trans_order table
        $insertOrder = mysqli_prepare($config, "INSERT INTO trans_order (order_code, id_customer, order_date, order_end_date, order_status, total) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insertOrder, "sisssi", $order_code, $id_customer, $order_date, $order_end_date, $order_status, $total_amount);

        if (!mysqli_stmt_execute($insertOrder)) {
            throw new Exception("Error inserting order: " . mysqli_error($config));
        }
        $order_id = mysqli_insert_id($config); // Get the ID of the newly inserted order

        // Get service details (id_service, qty, notes) from the form
        $id_services = $_POST['id_service'] ?? [];
        $quantities = $_POST['qty'] ?? [];
        $notes = $_POST['notes'] ?? [];

        // Loop through each service added in the form
        foreach ($id_services as $index => $service_id) {
            $service_id = (int)$service_id;
            $qty = (float)$quantities[$index]; // Quantity in Kg, stored in grams (x1000)
            $note = htmlspecialchars($notes[$index]);

            // Fetch service price
            $queryServicePrice = mysqli_query($config, "SELECT price FROM type_of_service WHERE id = '$service_id' AND deleted_at IS NULL");
            $rowServicePrice = mysqli_fetch_assoc($queryServicePrice);

            if ($rowServicePrice) {
                $price_per_kg = (float)$rowServicePrice['price'];
                $subtotal = $price_per_kg * $qty; // Calculate subtotal based on price per Kg
                $total_amount += $subtotal; // Add to total amount

                // Insert into trans_order_detail table
                $insertDetail = mysqli_prepare($config, "INSERT INTO trans_order_detail (id_order, id_service, qty, notes, subtotal) VALUES (?, ?, ?, ?, ?)");
                // Store quantity in grams (qty * 1000) if your database expects integer cents/grams
                // Otherwise, store as float directly. Assuming integer cents/grams based on existing code.
                $qty_db = $qty * 1000;
                $subtotal_db = $subtotal;
                mysqli_stmt_bind_param($insertDetail, "iisds", $order_id, $service_id, $qty_db, $note, $subtotal_db);
                if (!mysqli_stmt_execute($insertDetail)) {
                    throw new Exception("Error inserting order detail: " . mysqli_error($config));
                }
            } else {
                throw new Exception("Service with ID " . $service_id . " not found or deleted.");
            }
        }

        // Update the total amount in the trans_order table
        $updateOrderTotal = mysqli_prepare($config, "UPDATE trans_order SET total = ? WHERE id = ?");
        $total_amount_db = $total_amount; // Store total in cents/grams
        mysqli_stmt_bind_param($updateOrderTotal, "ii", $total_amount_db, $order_id);
        if (!mysqli_stmt_execute($updateOrderTotal)) {
            throw new Exception("Error updating order total: " . mysqli_error($config));
        }

        mysqli_commit($config); // Commit the transaction
        header("location:?page=trans-order&add=success"); // Redirect on success
        exit();
    } catch (Exception $e) {
        mysqli_rollback($config); // Rollback on error
        $error_message = $e->getMessage();
        // You might want to display this error message to the user or log it
        echo "<div class='alert alert-danger'>Error: " . $error_message . "</div>";
    }
}



if (isset($_GET['detail'])) {
    $id_order = $_GET['detail'];
    $queryOrder = mysqli_query($config, "SELECT o.*, c.customer_name FROM trans_order o LEFT JOIN customer c ON o.id_customer = c.id WHERE o.id = '$id_order'");
    if (mysqli_num_rows($queryOrder) == 0) {
        header("location:?page=order&data=notfound");
        exit();
    }
    $rowOrder = mysqli_fetch_assoc($queryOrder);

    $queryD = mysqli_query($config, "SELECT od.*, s.* FROM trans_order_detail od LEFT JOIN type_of_service s ON od.id_service = s.id WHERE id_order = '$id_order' ORDER BY od.id DESC");
    $rowD = mysqli_fetch_all($queryD, MYSQLI_ASSOC);

    if (isset($_POST['save2'])) {
        $id_order = $_GET['detail'];
        $id_customer = $rowOrder['id_customer'];
        $order_pay = $_POST['order_pay'];
        $order_change = $order_pay - $rowOrder['total'];
        $now = date('Y-m-d H:i:s');
        $pickup_date = $now;
        $order_status = 1;

        $update = mysqli_query($config, "UPDATE trans_order SET order_status='$order_status', order_pay='$order_pay', order_change='$order_change' WHERE id='$id_order'");
        if ($update) {
            mysqli_query($config, "INSERT INTO trans_laundry_pickup (id_order, id_customer, pickup_date) VALUES ('$id_order', '$id_customer', '$pickup_date')");
            header("location:?page=add-order&detail=" . $id_order . "&status=pickup");
        }
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php if (isset($_GET['detail'])) { ?>
                    <h5 class="card-title">Detail Order</h5>
                    <div class="table-responsive mb-3">
                        <div class="mb-3" align="right">
                            <a href="?page=order" class="btn btn-secondary">Back</a>
                        </div>
                        <table class="table table-stripped">
                            <tr>
                                <th>Code</th>
                                <td>:</td>
                                <td><?php echo $rowOrder['order_code']; ?></td>
                                <th>Date</th>
                                <td>:</td>
                                <td><?php echo $rowOrder['order_date']; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>:</td>
                                <td><?php echo $rowOrder['customer_name']; ?></td>
                                <th>End Date</th>
                                <td>:</td>
                                <td><?php echo $rowOrder['order_end_date']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>:</td>
                                <td><?php echo $rowOrder['order_status'] == 0 ? 'Process' : 'Picked Up'; ?></td>
                            </tr>
                        </table>
                        <br><br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type of Service</th>
                                    <th>qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowD as $key => $data) { ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td>
                                            <?php if (empty($data['notes'])) { ?>
                                                <?php echo $data['service_name']; ?>
                                            <?php } else { ?>
                                                <?php echo $data['service_name']; ?> <i class="ri ri-bookmark-fill cursor-pointer" data-bs-toggle="modal" data-bs-target="#note<?php echo $key + 1; ?>"></i>
                                                <!-- Modal Note -->
                                                <div class="modal fade" id="note<?php echo $key + 1; ?>" tabindex="-1" aria-labelledby="note<?php echo $key + 1; ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="note<?php echo $key + 1; ?>Label">Note</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <textarea readonly class="form-control"><?php echo $data['notes']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $data['qty'] / 1000; ?></td>
                                        <td><?php echo $data['price']; ?></td>
                                        <td><?php echo $data['subtotal']; ?></td>

                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td><?php echo $rowOrder['total']; ?></td>
                                </tr>
                                <?php if (isset($_GET['detail'])) { ?>
                                    <?php if ($rowOrder['order_status'] == 1) { ?>
                                        <tr>
                                            <td colspan="4">Pay</td>
                                            <td><?php echo $rowOrder['order_pay']; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Change</td>
                                            <td><?php echo $rowOrder['order_change']; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (isset($_GET['detail'])) { ?>
                        <?php if ($rowOrder['order_status'] == 0) { ?>
                            <div class="mb-3" align="center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pay">
                                    Pay
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <h5 class="card-title">Add Order</h5>
                    <div class="mb-3" align="right">
                        <a href="?page=trans-order" class="btn btn-secondary">Back</a>
                    </div>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                                    <input readonly type="text" id="code" class="form-control" value="<?= htmlspecialchars($code_form) ?>" required>
                                    <input type="hidden" name="order_code" value="<?= htmlspecialchars($code_form) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input readonly type="date" name="order_date" id="date" class="form-control" value="<?= htmlspecialchars(date('Y-m-d')) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="order_status" id="status" class="form-control">
                                        <option selected value="0">Process</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <select name="id_customer" id="name" class="form-control" required>
                                        <option value="">Choose Customer</option>
                                        <?php foreach ($rowsC as $data) { ?>
                                            <option value="<?= htmlspecialchars($data['id']) ?>"><?= htmlspecialchars($data['customer_name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date_end" class="form-label">Date End <span class="text-danger">*</span></label>
                                    <input type="date" min="<?= htmlspecialchars(date('Y-m-d')) ?>" name="order_end_date" id="date_end" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="mb-3" align="right">
                                <button type="button" id="addRow" class="btn btn-primary">Add Row</button>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-stripped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Type of Service</th>
                                            <th>Qty (Kg)</th>
                                            <th>Notes</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" name="save">Save</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pay" tabindex="-1" aria-labelledby="payLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="payLabel">Pay Order Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input readonly type="text" id="total" class="form-control" value="<?php echo $rowOrder['total']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pay" class="form-label">Pay (Rp)</label>
                        <input type="number" step="any" min="<?php echo $rowOrder['total']; ?>" name="order_pay" id="pay" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="save2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const addRowButton = document.querySelector('#addRow'); // Renamed `button` to `addRowButton` for clarity
    const tbody = document.querySelector('#myTable tbody');

    // Add event listener for the "Add Row" button
    addRowButton.addEventListener("click", function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="id_service[]" class="form-control" required>
                    <option value="">Choose Service</option>
                    <?php
                    // Make sure $rowService is available and contains data
                    // Reset the pointer of the $rowService array to the beginning
                    // so that the loop always starts from the first element
                    foreach ($rowService as $data) {
                    ?>
                        <option value="<?= htmlspecialchars($data['id']) ?>"><?= htmlspecialchars($data['service_name']) ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
            <td><input type="number" step="any" class="form-control" name="qty[]" placeholder="Enter your quantity" required></td>
            <td><textarea class="form-control" name="notes[]"></textarea></td>
            <td><button type="button" class="btn btn-danger delRow">Delete</button></td>
        `;
        tbody.appendChild(tr);
    });

    // Event delegation for deleting rows
    // This allows dynamically added "Delete" buttons to work
    tbody.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delRow')) {
            const tr = e.target.closest('tr'); // Find the closest parent <tr>
            if (tr) {
                tr.remove(); // Remove the row
            }
        }
    });
</script>