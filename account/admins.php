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
            <a class="btn btn-lg btn-primary rounded-5" href="#addAddressModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add Vendor
            </a>
        </div>
    </main>
</header>
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <main class="col-12">
                <div class="header d-flex justify-content-between align-items-start">
                    <h2 class="fs-4 mb-5"> Manage Vendors </h2>
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
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>John Doe</td>
                            <td>10/02/2022</td>
                            <td>10/02/2022</td>
                            <td><span class="bg-success text-light p-1 rounded-1"> Active </span></td>
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
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>John Doe</td>
                            <td>10/02/2022</td>
                            <td>10/02/2022</td>
                            <td><span class="text-light bg-warning p-1 rounded-1"> Pending </span></td>
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
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>John Doe</td>
                            <td>10/02/2022</td>
                            <td>10/02/2022</td>
                            <td><span class="text-light bg-danger p-1 rounded"> Blocked </span></td>
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
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</section>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>