<?php
    require_once("bootstrap/autoload.php");
    Login::restrictVisitors(Forms::postToSelf());
    if($cartObj->isEmpty()){
        $_SESSION["msg"]["warning"] = "Add items to your cart to access this page";
        Helper::redirectTo(3, "cart.php");
    }
    require_once(LAYOUTS_DIR ."/header.inc.php");
    $deliveryObj = new Delivery();
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <main class="col-md-8 mb-md-0 mb-4">
            <h4 class="h4 text-uppercase"> Delivery Options </h4>
            <p>Select the delivery method thats best for you</p>
            <hr class="hr mb-4">
            <?php 
                Helper::displayMessages(Session::getSession("msg"));
                if(count($deliveryObj->read()) > 0 ){
                    foreach($deliveryObj->read() as $option){
            ?>
                <div class="card card-body mb-4">
                    <div class="row g-0">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="bi bi-truck display-4"></span>
                        </div>
                        <div class="col-9 ps-md-1">
                            <div class="card-body">
                                <p class="card-text ps-2 mb-1 pt-1 fw-bold"><?= $option["name"] ?></p>
                                <p class="card-text ps-2 pb-3">
                                    Your order should be delivered within <?= $option["timeFrame"] ?> days </p>
                            </div>
                            Selected
                        </div>
                        <div class="col-1 d-flex align-items-center justify-content-center">
                            <div class="form-check">
                                <input type="radio" name="delivery_option" class="form-check-input"
                                id="deliveryOption<?= $option["id"] ?>" value="<?= $option["id"] ?>"
                                <?php
                                    $session_purchase = Session::getSession("purchase");
                                    if (!empty($session_purchase) 
                                        && 
                                        $session_purchase["delivery_id"] == $option["id"]
                                        )
                                    { 
                                        echo "checked";
                                    }
                                ?>
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <?php } unset($option); } else { ?>
                <div class="alert alert-info">
                    No product has been added to your wishlist.
                </div>
                <?php } ?>
            </main>
            <aside class="col-md-4">
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">Sub Total:</div>
                    <div class="p-2 bd-highlight">
                        <span class="fw-bold h5">$</span>
                        <span id="subTotal" class="fw-bold h5"><?= number_format($cartObj->get_sub_total(), 2); ?></span>
                    </div>
                </div>
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">Delivery Fee:</div>
                    <div class="p-2 bd-highlight">
                        <span class="fw-bold h5">$</span>
                        <span id="deliveryFee" class="fw-bold h5"><?= number_format($cartObj->get_delivery_fee(), 2); ?></span>
                    </div>
                </div>
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">Total:</div>
                    <div class="p-2 bd-highlight">
                        <span class="fw-bold h5">$</span>
                        <span id="total" class="fw-bold h5"><?= number_format($cartObj->get_final_price(), 2); ?></span>
                    </div>
                </div>
                <a href="<?= SITE_URL."/delivery_address.php" ?>" class="btn btn-success w-100"> Continue </a>
            </aside>
        </div>
    </div>
</section>
<?php 
    require_once(LAYOUTS_DIR ."/footer.inc.php");
?>