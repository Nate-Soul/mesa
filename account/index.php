<?php
require_once("../bootstrap/autoload.php");
require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
        <main class="container">
            <div class="bg-light p-5 rounded mt-3">
                <?= Helper::displayMessages(Session::get("msg")); ?>
            </div>
        </main>
    </header>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 d-flex align-items-start my-4">
                    <div class="icon-square icon bg-light text-dark flex-shrink-0 me-3">
                        <i class="bi bi-gift"></i>
                    </div>
                    <div>
                        <h2>Orders</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a href="<?= DASHBOARD_URL."/orders.php" ?>" class="btn btn-lg btn-primary rounded-5">
                            View Orders
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 d-flex align-items-start my-4">
                    <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                        <i class="bi bi-geo"></i>
                    </div>
                    <div>
                        <h2>Addresses</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a href="<?= DASHBOARD_URL."/addresses.php" ?>" class="btn btn-lg btn-primary rounded-5">
                            Manage Addresses
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 d-flex align-items-start my-4">
                    <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h2>Account &amp; Security</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a href="<?= DASHBOARD_URL."/profile.php" ?>" class="btn btn-lg btn-primary rounded-5">
                            Manage Account
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 d-flex align-items-start my-4">
                    <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                        <i class="bi bi-heart"></i>
                    </div>
                    <div>
                        <h2>Wishlist</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a href="<?= DASHBOARD_URL."/wishlist.php" ?>" class="btn btn-lg btn-primary rounded-5">
                            View Wishlist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>