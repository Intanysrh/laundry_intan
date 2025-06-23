<?php
include 'config/koneksi.php';
$query = mysqli_query($config, "SELECT * FROM users ORDER BY id DESC");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-user" class="btn btn-primary">Add User</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($row as $index => $data): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    <td><?php echo $data['email'] ?></td>
                                    <td>
                                        <a href="?page=tambah-user&edit=<?php echo $data['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a onclick="return confirm ('Are you sure?')" href="?page=tambah-user&delete=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>