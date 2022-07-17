<?php
require_once("../bootstrap/autoload.php");
require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <main class="container">
        <div class="bg-light p-5 rounded mt-3">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
        </div>
    </main>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">     
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-uppercase"> Your Orders </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $orders = $meObj->fetchUserOrders($_SESSION["user"]["id"]);
                        if(!empty($orders)){
                        foreach($orders as $order){
                        ?>
                        <div class="card card-body mb-4">
                            <div class="d-flex justify-content-between border-bottom">
                                <h6 class="h6 card-title"><?= $order["id"] ?></h6>
                                <div class="dropdown">
                                    <a class="dropdown-toggle card-link" href="javascript:void()" data-bs-toggle="dropdown">
                                        Order Details
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul class="dropdown-item">
                                            <li class="dropdown-item">Amount Paid: USD114.99</li>
                                            <li class="dropdown-item">Paid Using paypal</li>
                                            <li class="dropdown-item">On March 10, 2022, 11:43 a.m.</li>
                                            <li class="dropdown-item">By John Doe</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-toggle card-link" href="javascript:void()" data-bs-toggle="dropdown">
                                        Contact Details
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul class="dropdown-item">
                                            <li class="dropdown-item">sb-5u9xp13927101@personal.example.com</li>
                                            <li class="dropdown-item"></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-toggle card-link" href="javascript:void()" data-bs-toggle="dropdown"> Dispatch Address </a>
                                    <div class="dropdown-menu">
                                        <address class="dropdown-item">
                                            1 Main St, San Jose,<br>
                                            (95131) - ,
                                            US.
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 justify-content-between">
                                <figure class="figure text-center">
                                    <img src="/media/images/products/shirt-8.png" alt="sea green shirt" width="100" height="100">
                                    <figcaption>
                                        <a href="/product/easy-shirts-2022-edition/">
                                            <h6 class="h6">Easy Shirts 2022 Edition</h6>
                                        </a>
                                    </figcaption>
                                </figure>
                                <div class="add-ons">
                                    <a href="#" class="btn btn-primary w-100 my-1">Leave Review</a>
                                    <a href="#" class="btn btn-warning w-100 my-1">Problem With Order</a>
                                </div>
                            </div>
                        </div>
                    <?php } unset($order); } else { ?>
                    <div class="alert alert-info">Start shopping to see your orders here </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>