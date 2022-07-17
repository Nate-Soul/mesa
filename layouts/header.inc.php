<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Mesa </title>
    <link rel="stylesheet" href="<?= VENDOR_FILES_URL."/bootstrap/css/bootstrap.min.css" ?>">
    <link rel="stylesheet" href="<?= VENDOR_FILES_URL."/bootstrap/icons/bootstrap-icons.css" ?>">
    <link rel="stylesheet" href="<?= ASSETS_FILES_URL."/css/main.css" ?>">
</head>
<body>
    <!--header-->
    <header class="main-header" class="bg-theme-light">
        <nav id="top-nav" class="navbar navbar-expand-sm navbar-static-top">
            <div class="container">
                <ul class="nav navbar-nav welcome-label">
                    <li class="nav-item nav-link"> Welcome to Mesa stores </li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a href="shop.php" class="nav-link"><i class="bi bi-basket"></i> Shop </a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> Free Register </a></li>
                    <li class="nav-item">
                        <?php if (Login::isAuthenticated() === false){ ?>
                        <a href="<?= SITE_URL."/login.php" ?>" class="nav-link">
                            <i class="bi bi-lock"></i> Login
                        </a>
                        <?php } else { ?>
                        <a href="<?= DASHBOARD_URL ?>" class="nav-link">
                            <i class="bi bi-person-circle"></i> My Account
                        </a>
                        <?php } ?>                    
                    </li>
                </ul>
            </div>
        </nav>
        <div id="header-container" class="container">
            <div id="header-content" class="py-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-2 text-left">
                        <a href="<?= SITE_URL ?>">
                            <img src="media/images/logo/logo.png" alt="mesa's logo" height="50" width="50">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <form action="#" method="GET" class="mt-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" name="search" id="headerSearch" class="form-control" 
                                    placeholder="search for products, brands, categories...">
                                    <button type="submit" class="btn btn-main" id="headerSearchBtn">
                                        <span class="bi bi-search"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="text-center mt-3">
                            <li>
                                <a href="<?= DASHBOARD_URL."/" ?>wishlist.php">
                                    <i class="bi bi-heart"></i> Wishlist
                                </a>
                            </li>
                            <li>
                                <a href="cart.php" id="cartItems">
                                    <i class="bi bi-basket"></i> 
                                    <span><?= $cartObj->get_total_items(); ?></span> item(s)
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav id="main-menu" class="navbar navbar-expand-md">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="nav-link px-2 nav-lnk dropdown-toggle"> 
                            <i class="bi bi-list"></i> All Departments </a>
                        <div class="dropdown-menu">
                            <?php 
                            $categories = $categoryObj->read();
                            if(count($categories) > 0){ 
                                foreach($categories as $category){
                            ?>
                            <a href="<?= SITE_URL ?>/category.php?category=<?= $category["slug"] ?>" class="dropdown-item"> 
                                <?= ucwords($category["title"]) ?>
                            </a>
                            <?php }} ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="shop.php" class="nav-link px-2"> Shop </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-2"> Featured Brands </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-2"> Trending Styles </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-2"> Gift Cards </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    