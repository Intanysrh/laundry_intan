<?php
include 'config/koneksi.php';
$query = mysqli_query($config, "SELECT * FROM users ORDER BY id DESC");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Setting User Authorities</h5>

                <div class="content-container">
                    <form class="form-horizontal az-form" id="form" method="post" action="">
                        <div class="form-group">
                            <label class="control-label col-md-2">Access Authorization*</label>
                            <div class="col-md-5">
                                <select class="form-control" name="idrole" id="idrole">
                                    <option value="1">Administrator</option>
                                    <option value="2">Operator</option>
                                    <option value="3">Leader</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <h3>Setting Authorization</h3>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th width="10px">Access</th>
                                        <th>Authorization</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="role_name[]" value="dashboard">
                                        <td>Dashboard</td>
                                        <td>
                                            <input checked disabled type="checkbox" class="access access-dashboard" value="" name="access[dashboard]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="role_name[]" value="outlay">
                                        <td>Pengeluaran</td>
                                        <td>
                                            <input checked disabled type="checkbox" class="access access-outlay" value="1" name="access[outlay]">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="button">Save</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

</tbody>
</table>
</div>
</form>
</div>

</div>
</div>
</div>
</div>