<?php
    require("bootstrap/autoload.php");
    require_once(LAYOUTS_DIR."/header.inc.php");
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= Helper::displayMessages(Session::get("msg")); ?>
                <h2 class="h3">Your Cart</h2>
                <hr class="mb-5">
                <?php
                    if(!$cartObj->isEmpty())
                    {
                ?>
                <table class="table table-cart">
                    <thead>
                        <th colspan="2">Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th colspan="2">Total</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($cartObj->getCartItems() as $cart_item){
                        ?>
                        <tr id="cartRow<?= $cart_item["id"] ?>">
                            <td>
                                <a href="<?= SITE_URL ?>/single.php?product=<?= $cart_item["slug"] ?>">
                                    <?= $cart_item["name"] ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= SITE_URL ?>/single.php?product=<?= $cart_item["slug"] ?>">
                                    <img src="<?= PRODUCTS_URL.$cart_item["image"] ?>" width="80" height="80">
                                </a>
                            </td>
                            <td>&dollar;<?= number_format($cart_item["price"], 2) ?></td>
                            <td>
                                <div class="input-group">
                                    <button><span class="fa fa-minus"></span></button>
                                    <?= $_SESSION[$cartObj->cart_name][$cart_item["id"]]["qty"] ?>
                                    <button><span class="fa fa-minus"></span></button>
                                </div>
                            </td>
                            <td id="totalPrice">&dollar;
                                <span>
                                    <?= number_format(
                                        $_SESSION[$cartObj->cart_name][$cart_item["id"]]["total"], 2) ?>
                                </span>
                            </td>
                            <td>
                                <a href="javascript:void" class="delete-from-cart-btn" data-index="<?= $cart_item["id"] ?>">
                                    <span class="bi bi-trash"></span>
                                </a>
                            </td>
                        </tr>
                        <?php
                            } unset($cart_item);
                        ?>
                    </tbody>
                </table>
                <?php } else { ?>
                    <div class="alert alert-info">Your cart is currently empty, start adding items to continue</div>
                <?php } ?>
            </div>
            <div class="col-md-8 mt-5 mb-md-0 mb-4">
                <h3 class="h4 mb-4">Cart Totals</h3>
                <table class="table table-bordered">
                    <tbody>
                        <th>Subtotal</th>
                        <td id="subTotal">&dollar;<span><?= number_format($cartObj->get_sub_total(), 2) ?></span></td>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <a href="<?= SITE_URL."/delivery_options.php" ?>" class="btn btn-primary w-100 rounded-3 my-1">Proceed to Checkout</a>
                <a href="<?= SITE_URL ?>" class="btn btn-outline-secondary w-100 rounded-3 my-1">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>
<?php include_once(LAYOUTS_DIR."/footer.inc.php"); ?>