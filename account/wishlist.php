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
                        <h4 class="card-title text-uppercase"> Your Wishlist </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $wishlist = $meObj->fetchUserWishlist($_SESSION["user"]["id"]);
                            if(!empty($wishlist)){
                            foreach($wishlist as $item){
                            ?>
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="card">
                                    <div class="row g-0">
                                        <figure class="col-md-4">
                                            <img src="<?= PRODUCTS_URL ?>shoe-7.png" alt="Cyan Electric Shoes" class="img-fluid d-block">
                                        </figure>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="card-title">Electric Sneakers</h6>
                                                <p class="card-text small text-muted">USD68.44</p>
                                                <p class="card-text">Get rolling with bluemall&#x27;s electric sneakers</p>
                                                <a href="/account/wishlist/4/add/" class="btn btn-sm btn-primary">Remove From Wishlist</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } unset($item); } else { ?>
                            <div class="alert alert-info">Start adding your addresses </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>