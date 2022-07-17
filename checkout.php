<?php
    require_once("bootstrap/autoload.php");
    Login::restrictVisitors(Forms::postToSelf());
    if($cartObj->isEmpty()){
        $_SESSION["msg"]["warning"] = "Add items to your cart to access this page";
        Helper::redirectTo(3, SITE_URL."/cart.php");
    }
    if(
        empty(Session::getSession("address") || !isset(Session::getSession("address")["address_id"]))
    )
    {
        $_SESSION["msg"]["warning"] = "please select a delivery address to continue";
        Helper::redirectTo(3, SITE_URL."/delivery_address.php");
    }
    require_once(LAYOUTS_DIR ."/header.inc.php");
    $addressObj = new Addresses();
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <main class="col-md-8 mb-md-0 mb-4">
                <h4 class="h4 text-uppercase"> Order Summary </h4>
                <hr class="hr mb-4">
                <?php 
                    Helper::displayMessages(Session::getSession("msg"));
                    if($cartObj->get_total_items() > 0)
                    {
                        foreach($cartObj->getCartItems() as $product)
                        {
                ?>
                <div class="card mb-4">
                    <div class="row g-0">
                        <figure class="col-md-4">
                            <img class="img-fluid" src="<?= PRODUCTS_URL.$product["image"] ?>"
                            alt="<?= $product["name"] ?>">
                        </figure>
                        <div class="col-md-8 d-flex flex-column align-self-center">
                            <h5 class="card-title h4"><?= ucwords($product["name"]) ?></h5>
                            <p class="card-text fs-5"><strong>Price:</strong> <?= number_format($product["price"], 2) ?></p>
                            <p class="card-text fs-5">
                                <strong>Quantity:</strong> &times;
                                <?= $_SESSION[$cartObj->cart_name][$product["id"]]["qty"] ?>
                            </p>
                            <p class="card-text fs-5">
                                <strong>Total Price:</strong> &dollar;
                                <?= number_format($_SESSION[$cartObj->cart_name][$product["id"]]["total"], 2) ?></p>
                        </div>
                    </div>
                </div>
                <?php } unset($product); } else { ?>
                <div class="alert alert-info">
                    No item(s) available, start <a href="<?= SITE_URL."/cart.php" ?>">adding items</a> to your cart to continue.
                </div>
                <?php } ?>
            </main>
            <aside class="col-md-4">
            <?php 
                $session_purchase = Session::getSession("purchase");
                if(!empty($session_purchase) && isset($session_purchase["delivery_id"]))
                {
                    $deliveryObj = new Delivery();
                    $delivery_option = $deliveryObj->getDeliveryById($session_purchase["delivery_id"]);
            ?>
                <div class="card card-body mb-4">
                    <h5 class="card-text h5 fw-bold"> Delivery Method </h5>
                    <p class="card-text ps-2 mb-1 pt-1 fw-bold"><?= $delivery_option["name"] ?></p>
                    <p class="card-text ps-2 pb-3">
                        Your order should be delivered within <?= $delivery_option["timeFrame"] ?> days.
                    </p>
                </div>
            <?php }
                $session_address = Session::getSession("address");
                if(!empty(Session::getSession("address") && isset($session_address["address_id"]))){
                    $address = $addressObj->getUserAddressById($session_address["address_id"], Session::getSession("user")["id"]);
            ?>
                <div class="card card-body mb-4">
                    <h5 class="card-text h5 fw-bold"> Dispatch Address </h5>
                    <address class="address">
                        <?= $address["address_1"].", ".$address["address_2"].", ".$address["city"].
                        ", ".$address["state"]. "(" .$address["postalCode"] ."), ". $address["name"] ?>.
                    </address>
                </div>
            <?php } ?>
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
                <a href="<?= SITE_URL."/order_placed.php" ?>" class="btn btn-success w-100 my-1"> Place Order </a>
                <a href="<?= SITE_URL."/cart.php" ?>" class="btn btn-outline-secondary w-100 my-1"> Update Cart </a>
            </aside>
        </div>
    </div>
</section>
<?php 
    require_once(LAYOUTS_DIR ."/footer.inc.php");
?>