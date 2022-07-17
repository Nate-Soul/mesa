<?php
Login::restrictVisitors(Forms::postToSelf());
$meObj   = new Users();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mesa </title>
    <link rel="stylesheet" href="<?= VENDOR_FILES_URL . "/bootstrap/css/bootstrap.min.css" ?>">
    <link rel="stylesheet" href="<?= VENDOR_FILES_URL . "/bootstrap/icons/bootstrap-icons.css" ?>">
    <link rel="stylesheet" href="<?= ASSETS_FILES_URL . "/css/main.css" ?>">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark static-bottom ">
            <div class="container">
                <a class="navbar-brand" href="<?= SITE_URL ?>">Mesa</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= DASHBOARD_URL ?>">
                                <span class="bi bi-speedometer2"></span> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>/cart.php">
                                <span class="bi bi-cart4"></span> Your Cart
                            </a>
                        </li>
                        <?php if (Login::isAdminOrAuthor()) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="bi bi-layout-wtf"></span> CMS
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?= DASHBOARD_URL . "/categories.php" ?>">Categories</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= DASHBOARD_URL . "/products.php" ?>">Products</a>
                                    </li>
                                    <?php if (Login::isAdmin()) { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?= DASHBOARD_URL . "/user_orders.php" ?>">User Orders</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= DASHBOARD_URL . "/delivery.php" ?>">Delivery</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= DASHBOARD_URL . "/users.php" ?>">Users</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= DASHBOARD_URL . "/vendors.php" ?>">Vendors</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= DASHBOARD_URL . "/settings.php" ?>">Site Settings</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if (!empty(Session::get("user")["avatar"])) { ?>
                                    <img src="<?= AVATARS_URL . Session::get("user")["avatar"] ?>" class="img-fluid rounded-circle" height="30" width="30" alt=""> <?php } else { ?>
                                    <span class="bi bi-person-circle"></span> <?php } ?> Hi <?= Session::get("user")["firstName"] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= DASHBOARD_URL . "/orders.php" ?>">Your Orders</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= DASHBOARD_URL . "/addresses.php" ?>">Your Addresses</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= DASHBOARD_URL . "/wishlist.php" ?>">Your Wishlist</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= DASHBOARD_URL . "/profile.php" ?>">Your Account</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= SITE_URL ?>" target="_blank">View Site</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= DASHBOARD_URL . "/logout.php" ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>