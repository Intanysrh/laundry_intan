<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "UPDATE users SET deleted_at=1 WHERE id = $id_user");
    if ($queryDelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}

if (isset($_POST['name'])) {
    // jika ada parameter bernama edit, maka jalankan perintah edit/update. Kalo tidak ada, mnaka tambahkan data baru/insert.
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : '';
    $id_level = isset($_POST['id_level']) ? $_POST['id_level'] : '';
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO users (name, email, password, id_level) VALUES('$name','$email','$password', '$id_level')");
        header("location:?page=user&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE users SET name = '$name', email = '$email', password = '$password', id_level = '$id_level'  WHERE id = '$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}

if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $id = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM users WHERE id = $id");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
} else {
    $rowEdit = []; // atau bisa diatur sesuai kebutuhan
}


$queryLevel = mysqli_query($config, "SELECT * FROM level");
$rowLevel = mysqli_fetch_all($queryLevel, MYSQLI_ASSOC);


?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title"></h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?php echo isset($rowEdit['name']) ? ($rowEdit['name']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo isset($rowEdit['email']) ? ($rowEdit['email']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" <?php echo empty($_GET['edit']) ? 'required' : '' ?>>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Level *</label>
                        <select name="id_level" class="form-control" id="">
                            <option value="">Select One</option>
                            <?php foreach ($rowLevel as $data): ?>
                                <option <?php echo isset($_GET['edit']) ? ($data['id'] == $rowEdit['id_level'] ? 'selected' : '') : '' ?> value="<?php echo $data['id'] ?>"><?php echo $data['level_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Role Name</label>
                        <select name="id_role" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowRoles as $rowRole): ?>
                                <option value="<?php echo $rowRole['id'] ?>"><?php echo $rowRole['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form> -->

        </div>
    </div>
</div>