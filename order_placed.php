<?php


require_once("bootstrap/autoload.php");

$cartObj->clear();

require_once(LAYOUTS_DIR."/header.inc.php");

?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2> Your order was placed successfully</h2>
                <hr>
                <p class="lead">Navigate to your <a href="<?= DASHBOARD_URL."/orders.php" ?>">dashboard</a> to view your orders</p>
            </div>
        </div>
    </div>
</section>
<?php
require_once(LAYOUTS_DIR."/footer.inc.php");
?>