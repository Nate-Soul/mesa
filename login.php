<?php
    require("bootstrap/autoload.php");
    $errors = array();

    if( Forms::isPost() 
        && Forms::assertPost("token")
        ){

        $adminObj = new Users();
        $loginObj = new Login();

        $token    = Forms::getPost("token");
        $login    = Forms::getPost("login");
        $password = Forms::getPost("passkey");
        $remember = Forms::getPost("remember");

        /* validate variables here
        if ($remember == "on"){
            // set cookie one week (value in seconds)
            session_set_cookie_params('604800');
            session_regenerate_id(true);
        }
        */

        
        if(!Token::checkCSRFToken($token)){
            $errors[] = "Something went wrong, refresh the form and try again";
        } else {
            if(empty($login) || empty($password)){
                $errors[] = "Fields Cannot Be Empty";
            } else {
                if(!preg_match("/^[a-zA-Z0-9\/-_\s]+$/", $login) && !filter_var($login, FILTER_VALIDATE_EMAIL)){
                    $errors[] = "login must be a valid username/email address";
                }
                $userDetails  = $adminObj->fetchUserByLogin($login);
                if($userDetails){
                    $userPassword = $userDetails["password"];
                    $userActive   = $userDetails["isActive"];
                    $checkPsw     = password_verify($password, $userPassword);
                    //check if user exist or password is correct
                    if($checkPsw === false){
                        $errors[] = "Username/Password is incorrect";
                    }//check if user exists and account is activated
                    if(!$userActive){
                        $errors[] = "You're Registered, activate your account from your email to continue";
                    }
                } else {
                    $errors[] = "Username/Password is incorrect";
                }
            }
            
            //check if errors is empty and user login exist and password is verified and account is activated
            if(empty($errors) === true && $userDetails && $checkPsw === true && $userDetails["isActive"] == 1){
                $loginObj->loginUser($login, Url::getRefererUrl());
            }
        }
    
    }

    require_once(LAYOUTS_DIR."/header.inc.php");
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <main class="col-md-5 mx-md-auto">
                <div class="card card-body border-0 shadow-sm p-5">
                    <h3 class="h3 card-title mb-4 text-main">Login</h3>
                    <?php Helper::displayErrors($errors);?>
                    <?php Helper::displayMessages(Session::get("msg")); ?>
					<?php if(Login::isAuthenticated()){ ?>
                    <p class="text-info">
                        You're logged in. Navigate to <a href="<?= DASHBOARD_URL ?>">Dashboard</a>
                    </p>
					<?php } else { ?>
                    <form action="<?= Forms::postToSelf() ?>" method="POST">
                        <div class="mb-3">
                            <label for="login"> Email Address </label>
                            <input class="form-control" placeholder="Your Email Address *" type="email" 
                            name="login" id="login" <?= Forms::stickyText("login") ?> required>
                        </div>
                        <div class="mb-3">
                            <label for="passKey"> Password </label>
                            <input class="form-control" placeholder="Your Password *" type="password" 
                            name="passkey" id="passKey" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember">Keep me logged in</label>
                        </div>
                        <div class="mb-3 text-end">
                            <a href="#forgotten_password.php">Forgotten Password?</a>
                        </div>
                        <div class="mt-3">
                            <?= csrf_token() ?>
                            <button type="submit" class="btn btn-lg rounded-3 btn-main w-100">Login</button>
                        </div>
                    </form>
					<?php } ?>
                </div>
            </main>
        </div>
    </div>
</section>
<?php 
    require_once(LAYOUTS_DIR."/footer.inc.php");
?>