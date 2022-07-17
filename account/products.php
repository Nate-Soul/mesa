<?php
require_once("../bootstrap/autoload.php");
Login::restrictUsers();
require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <main class="container-fluid">
        <div class="bg-light p-3 rounded">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
            <a class="btn btn-lg btn-primary rounded-5" href="#addAddressModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add Product
            </a>
        </div>
    </main>
</header>
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <main class="col-12">
                <div class="section-header d-flex justify-content-between align-items-start">
                    <h2 class="fs-4 mb-5"> Manage Products </h2>
                    <a href="#" class="btn btn-danger d-none">Delete Selected <span class="bi bi-trash"></span></a>
                </div>
                <table class="table table-striped fs-6">
                    <thead class="text-uppercase">
                        <th> <input type="checkbox" name="" id=""> </th>
                        <th> Product </th>
                        <th> Title </th>
                        <th> Regular Price </th>
                        <th> Discount Price </th>
                        <th> In Stock </th>
                        <th> Created </th>
                        <th> Modified </th>
                        <th> Product Safe URL </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><img src="<?= PRODUCTS_URL ?>shoe-7.png" alt="product-title" height="50" width="50"></td>
                            <td>Flying Wheels</td>
                            <td>&dollar;450.00</td>
                            <td>&dollar;300.00</td>
                            <td><input type="checkbox" name="" id="" checked></td>
                            <td>12/02/2022</td>
                            <td>28/05/2022</td>
                            <td>flying-wheel</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><img src="<?= PRODUCTS_URL ?>shirt-8.png" alt="product-title" height="50" width="50"></td>
                            <td>Labrador Shirt</td>
                            <td>&dollar;450.00</td>
                            <td>&dollar;300.00</td>
                            <td><input type="checkbox" name="" id="" checked></td>
                            <td>12/02/2022</td>
                            <td>28/05/2022</td>
                            <td>labrador-shirt</td>
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