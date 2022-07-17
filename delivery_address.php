<?php
    require_once("bootstrap/autoload.php");
    Login::restrictVisitors($_SERVER["REQUEST_URI"]);
    if($cartObj->isEmpty()){
        $_SESSION["msg"]["warning"] = "Add items to your cart to access this page";
        Helper::redirectTo(3, "cart.php");
    }
    if(!isset(Session::getSession("purchase")["delivery_id"]) ){
        $_SESSION["msg"]["warning"] = "please select a delivery option to continue";
        Helper::redirectTo(3, "delivery_options.php");
    }

    require_once(LAYOUTS_DIR."/header.inc.php");

    $addressObj = new Addresses();

    $userID = Session::getSession("user")["id"];
    
    $default_user_address = $addressObj->getUserDefaultAddress($userID);
    if(!empty($default_user_address)){
        if(!isset($_SESSION["address"])){
            Session::setSession("address", array(
                "address_id" => $default_user_address["id"]
            ));
        } else {
            unset(Session::getSession("address")["address_id"]);
            $_SESSION["address"]["address_id"] = $default_user_address["id"];
        }
    }
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <main class="col-md-8 mb-md-0 mb-4">
            <h4 class="h4 text-uppercase"> Delivery Address </h4>
            <p>Add or select the delivery address most comfortable for you</p>
            <hr class="hr mb-4">
            <?php 
                Helper::displayMessages(Session::getSession("msg"));
                if($addressObj->getUserAddressesCount($userID) > 0 ){
                    foreach($addressObj->getUserAddresses($userID) as $address){
            ?>
                <div class="card card-body mb-4">
                    <div class="row g-0">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="bi bi-pin fs-2 <?php if($address["isDefault"]){ echo "text-primary"; } ?>"></span>
                        </div>
                        <div class="col-10 ps-md-1">
                            <div class="card-body">
                                <?php if($address["isDefault"]){ ?><h5 class="fw-bold h5">Default Address</h5><?php } else { ?>
                                <h5 class="fw-bold h5">Other Address</h5><?php } ?>
                                <address class="address">
                                    <?= $address["address_1"].", ".$address["address_2"].", ".$address["city"].
                                    ", ".$address["state"]. " (" .$address["postalCode"] ."), ". $address["name"] ?>.
                                </address>
                                <a href="#" class="card-link">
                                    <span class="bi bi-pen"></span> Edit Address
                                </a>
                                <?php if(!$address["isDefault"]){ ?>
                                <a href="#" class="card-link">
                                    <span class="bi bi-pen"></span> Select Address
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } unset($option); } else { ?>
                <div class="alert alert-info">
                    No addresses added on your account. <a href="<?= DASHBOARD_URL."addresses.php?next_page=delivery_address.php" ?>">Add address here </a>
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
                <a href="<?= SITE_URL."/checkout.php" ?>" class="btn btn-success w-100"> Continue </a>
            </aside>
        </div>
    </div>
</section>
<?php 
    require_once(LAYOUTS_DIR ."/footer.inc.php");
?>