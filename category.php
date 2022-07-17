<?php
    ob_start();
    require("bootstrap/autoload.php");
    $productObj = new Products();
    $slug       = URL::getParam("category");
    require_once(LAYOUTS_DIR."/header.inc.php");
    $category   = $categoryObj->getCategoryBySlug($slug);
    if(empty($category)){
        header("location: shop.php");
    }
?>
<section class="section py-5">
    <div class="container">
        <div class="row">
                <h3 class="h3"> <?= ucwords($category["title"]) ?> </h3>
                <?php 
                    $products = $productObj->getProductsByCategory($category["title"]);
                    if(!empty($products)){
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
                                <?php //$cartObj->add($product["id"]); ?>
                            </figcaption>
                        </figure>
                        <!-- PRODUCT CARD ENDS -->
                    </div>
                    <?php 
                        } unset($product);
                    } else{
                    ?>
                    <div class="alert alert-info">
                        No items in this category yet! <a href="<?= SITE_URL."/shop.php" ?>">Continue Shopping</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once(LAYOUTS_DIR."/footer.inc.php"); ob_end_flush(); ?>