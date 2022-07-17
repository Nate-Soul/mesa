<?php
    require("bootstrap/autoload.php");
    $productObj  = new Products();
    require_once(LAYOUTS_DIR."/header.inc.php");
?>
    <section id="showCase">
        <div class="container">
            <div class="content-p-sm">
                <div class="row">
                    <div class="col-md-12">
                        <div id="main-slider" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#main-slider" data-bs-slide-to="0" class="active"></li>
                                <li data-bs-target="#main-slider" data-bs-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <figure class="carousel-item active">
                                    <img src="media/images/gallery/bootstrap_free-ecommerce.png" alt="banner-1" class="d-block mx-auto img-fluid">
                                </figure>
                                <figure class="carousel-item">
                                    <img src="media/images/gallery/bootstrap_free-ecommerce.png" alt="banner-1" class="d-block mx-auto img-fluid">
                                </figure>
                            </div>
                            <!--controls-->
                            <a href="#main-slider" class="carousel-control-prev" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a href="#main-slider" class="carousel-control-next" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="special-categories">
        <div class="container">
            <div class="content-p-sm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="special-category-card shadow-sm rounded-3 
                        p-3 mb-md-0 mb-4 d-flex justify-content-center bg-theme-light">
                            <span class="bi bi-truck"></span>
                            <p>
                                Free Shipping - Only available for people living in uyo
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="special-category-card shadow-sm rounded-3 
                        p-3 mb-md-0 mb-4 d-flex justify-content-center bg-theme-light">
                            <span class="bi bi-arrow-repeat"></span>
                            <p>
                                Refresh - Get special offers just sync with our mobile app.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="special-category-card shadow-sm rounded-3 
                        p-3 mb-md-0 mb-4 d-flex justify-content-center bg-theme-light">
                            <span class="bi bi-emoji-smile"></span>
                            <p>
                                Customer happiness is what we strive for
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="home-products">
        <div class="content-p-sm">
            <div class="container">
                <div class="row">
                    <!-- grouped products -->
                    <main id="grouped-products"  class="col-md-12">
                        <nav>
                            <ul class="nav nav-tabs justify-content-end" role="tablist">
                                <li class="nav-item">
                                    <a href="#featured" data-bs-toggle="tab" class="nav-link h5 active" role="tab"> 
                                        Featured 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#on-sale" data-bs-toggle="tab" class="nav-link h5" role="tab"> 
                                        On sale 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#top-rated" data-bs-toggle="tab" class="nav-link h5" role="tab"> 
                                        Top Rated 
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-content">
                            <div class="tab-pane fade container show active" id="featured">
                                <div class="row">
                                    <?php 
                                        $products = $productObj->read();
                                        if(count($products) > 0){
                                            foreach($products as $product)
                                            {
                                    ?>
                                    <div class="col-md-3 my-4">
                                        <!-- PRODUCT CARD -->
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
                                                    <a href="javascript:void()" role="button" data-index="<?= $product["id"] ?>"
                                                    class="btn btn-sm btn-outline-primary me-1 add-to-cart-btn">
                                                        <span class="bi bi-cart-plus"></span> Add to Cart
                                                    </a>
                                                    <a href="javascript:void()" class="btn btn-sm btn-outline-primary ms-1">
                                                        <span class="bi bi-heart"></span> Add to Wishlist
                                                    </a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                        <!-- PRODUCT CARD ENDS -->
                                    </div>
                                    <?php
                                    } unset($product);
                                        } else {
                                    ?>
                                    <div class="alert alert-info">
                                        No products available at the moment, check back later. Merci.
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane fade container" id="on-sale">
                                <div class="row">
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade container" id="top-rated">
                                <div class="row">
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                    <div class="col-md-4 my-4">
                                        <p> This is the featured products tab </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <!--// grouped products ends here -->
                </div>
            </div>
        </div>
    </section>


<?php include_once(LAYOUTS_DIR."/footer.inc.php"); ?>