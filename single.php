<?php
    require("bootstrap/autoload.php");
    $productObj = new Products();
    $slug       = URL::getParam("product");
    $product    = $productObj->getProductBySlug($slug);
    if(empty($product)){
        Helper::redirectTo(3, "shop.php");
    }
    require_once(LAYOUTS_DIR."/header.inc.php");
?>
<section class="section py-5">
    <div class="container">
        <div class="row">
            <aside class="col-md-6 mb-md-0 mb-4">
                <div class="card card-body">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <figure class="carousel-item active">
                                <img src="<?= PRODUCTS_URL.$product["image"] ?>" alt="<?= $product["name"] ?>" class="img-fluid">
                            </figure>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </aside>
            <main class="col-md-6">
                <div class="card card-body product-short-detail mb-4 p-4">
                    <h4 class="card-title prim-color"> <?= $product["name"] ?> </h4>
                    <p class="card-text desc"><?= $product["slug"] ?></p>
                    <p class="qty">
                        <label for="select">Quantity</label>
                        <select name="select_qty" id="selectQty" class="custom-select">
                            <optgroup>
                            <?php for($x = 1; $x <= (int)$product["available_qty"]; $x++){ ?>
                                <option value="<?= $x ?>"><?= $x ?></option>
                            <?php } ?>
                            </optgroup>
                        </select>
                    </p>
                    <p class="card-text details">
                        <strong> Price </strong> &dollar;
                        <?= number_format($product["price"], 2) ?> <br>
                        <strong> Category: </strong> <?= $product["category"] ?> <br>
                        <strong> Availability: </strong> <?php if($product["in_stock"] == 1){ echo "In Stock"; } else { echo "Out of Stock"; } ?> <br><br>
                        <button id="addToCartBtn" type="button" data-index="<?= $product["id"] ?>" 
                        class="btn btn-primary btn-lg rounded-5 me-1">
                            <span class="bi bi-cart-plus"></span> Add to cart
                        </button>
                        <a id="addToWishlistBtn" href="#" 
                        class="btn btn-outline-secondary btn-lg rounded-5 ms-1">
                            <span class="bi bi-heart"></span> Add to wishlist
                        </a>
                </div>
            </main>
            <main class="col-12 py-5">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" 
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Product Description</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" 
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Product Reviews</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <p>
                            <strong>This tab displays the product information in full details.</strong>.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <p>
                            <strong> This tab displays product reviews and a review form for customers who have bought the product before.</strong>
                        </p>
                    </div>
                </div>
            </main>
            <div class="col-12">
                <h3 class="h3">Related Products</h3>
                <div class="row">
                <?php 
                    $products = $productObj->getRelatedProducts($product["name"]);
                    if(count($products) > 0){
                        foreach($products as $product){ ?>
                    <div class="col-md-3 my-4">
                        <!-- product card -->
                        <figure class="text-center shadow-sm p-3">
                            <a href="<?= SITE_URL ?>/single.php?product=<?= $product["slug"] ?>">
                                <img src="<?= PRODUCTS_URL.$product["image"] ?>" alt="<?= $product["name"] ?>" class="img-fluid">
                            </a>
                            <figcaption>
                                <a href="<?= SITE_URL ?>/single.php?product=<?= $product["slug"] ?>">
                                    <h6 class="h6"><?= $product["name"] ?></h6>
                                </a>
                                <p class="fs-5 fw-bold text-main">&dollar;<?= $product["price"] ?></p>
                                <div class="mt-4">
                                    <a href="#" role="button" data-index="<?= $product["id"] ?>"
                                    class="btn btn-sm btn-outline-primary me-1 add-to-cart-btn">
                                        <span class="bi bi-cart-plus"></span> Add to Cart
                                    </a>
                                    <a href="<?= SITE_URL ?>" class="btn btn-sm btn-outline-primary ms-1">
                                        <span class="bi bi-heart"></span> Add to Wishlist
                                    </a>
                                </div>
                            </figcaption>
                        </figure>
                        <!-- PRODUCT CARD ENDS -->
                    </div>
                    <?php 
                        } unset($product);
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once(LAYOUTS_DIR."/footer.inc.php"); ?>