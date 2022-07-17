<?php
require_once("../bootstrap/autoload.php");
Login::restrictVendors();

require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <main class="container-fluid">
        <div class="bg-light p-3 rounded">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
            <a class="btn btn-lg btn-primary rounded-5" href="#addUserModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add User
            </a>
        </div>
    </main>
</header>
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <main class="col-12">
                <div class="header d-flex justify-content-between align-items-start">
                    <h2 class="fs-4 mb-5"> Manage Users </h2>
                    <a href="#" class="btn btn-danger d-none">Deleted Selected <span class="bi bi-trash"></span></a>
                </div>
                <table class="table table-striped table-justify fs-6">
                    <thead class="text-uppercase">
                        <th><input type="checkbox"></th>
                        <th>Full Name</th>
                        <th>Last Login</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php 
                            if($meObj->read()){
                            foreach($meObj->read() as $user){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><?= $user["firstName"]. " " .$user["lastName"] ?></td>
                            <td><?= $user["lastLogin"] ?></td>
                            <td><?= $user["registeredAt"] ?></td>
                            <td><span class="bg-success text-light p-1 rounded-1"> <?= ($user["isActive"]) ? "Active" : "Inactive" ; ?></span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <span class="bi bi-pen"></span> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-warning">
                                    <span class="bi bi-pen"></span> Change Password
                                </a>
                                <a href="#" class="btn btn-sm btn-danger">
                                    <span class="bi bi-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</section>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>