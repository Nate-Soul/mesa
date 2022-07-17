<?php
    require("bootstrap/autoload.php");
    $errors = array();
    $messages = array();

    if(Forms::isPost() && Forms::assertPost("token"))
    {
        $userObj = new Users();

        $token     = Forms::getPost("token");
        $firstName = Forms::getPost("firstName");
        $lastName  = Forms::getPost("lastName");
        $email     = Forms::getPost("emailAddress");
        $password  = Forms::getPost("passkey");
        $password2 = Forms::getPost("passkey2");

        if(Token::checkCSRFToken($token)){
            if(empty($email) || empty($email) || empty($password2) || empty($firstName) || empty($lastName)){
                $errors[] = "Fields Cannot Be Empty";
            } else {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors[] = "please provide a valid email address";
                }

                if($password != $password2){
                    $errors[] = "Passwords do not match";
                }

                //check if account already exists
                if($userObj->fetchUserByLogin($email)){
                    $errors[] = "A user with this email address already exists";
                }
            }
        } else {
            $errors[] = "Something went wrong, please reload the form and try again";
        }

        if(empty($errors)){
            $imageObj = new Image();
            $initials = strtoupper($firstName[0]).strtoupper($lastName[0]);
            $avatar   = $imageObj->createInitialAvatar($initials);
            $hash_password = Forms::encryptPsw($password);
            $activationCode = Token::generateActivationCode();
            $expiry        = 1 * 24 * 60 * 60;
            $data = array(
                "firstName" => ucfirst($firstName), 
                "lastName"  => ucfirst($lastName), 
                "email"     => $email,
                "password"  => $hash_password,
                "activationCode" => Forms::encryptPsw($activationCode),
                "activationExpiry" => date('Y-m-d H:i:s', time() + $expiry),
                "avatar"    => $avatar
            );
            $emailObj = new Email();
            $sendMail = $emailObj->process("account_activation", array(
                'name'      => $firstName. ' '.$lastName,
                'email'		=> $email,
                'hash'		=> $activationCode
                ));
            if($userObj->add($data) && $sendMail)
            {
                $messages[] = "Account Registration Successful! We've sent a mail to help you activate your account";
                Helper::redirectTo(1, SITE_URL."/login.php");
            } else {
                $errors[] = "Registration Failed! please try again later";
            }
        }
    
    }

    require_once(LAYOUTS_DIR."/header.inc.php");
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <main class="col-md-7 mx-md-auto">
                <div class="card card-body border-0 shadow-sm p-5">
                    <h3 class="h3 card-title mb-4 text-main">Register for Free</h3>
                    <?php Helper::displayErrors($errors);?>
                    <?php Helper::displaySuccesses($messages);?>
                    <?php Helper::displayMessages(Session::get("msg")); ?>
					<?php if(Login::isAuthenticated()){ ?>
                    <p class="text-info">
                        You're logged in. Navigate to <a href="<?= DASHBOARD_URL ?>">Dashboard</a>
                    </p>
					<?php } else { ?>
                    <form action="<?= Forms::postToSelf() ?>" method="POST">
                        <div class="mb-3">
                            <label for="firstName"> First Name </label>
                            <input class="form-control" placeholder="Your First Name *" 
                            type="text" name="firstName" id="firstName" <?= Forms::stickyText("firstName") ?> required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName"> Last Name </label>
                            <input class="form-control" placeholder="Your Last Name *" 
                            type="text" name="lastName" id="lastName" <?= Forms::stickyText("lastName") ?> required>
                        </div>
                        <div class="mb-3">
                            <label for="emailAddress"> Email Address </label>
                            <input class="form-control" placeholder="Your Email Address *" 
                            type="email" name="emailAddress" id="emailAddress" <?= Forms::stickyText("emailAddress") ?> required>
                        </div>
                        <div class="mb-3">
                            <label for="passKey"> Password </label>
                            <input class="form-control" placeholder="Your Password *" 
                            type="password" name="passkey" id="passKey" required>
                        </div>
                        <div class="mb-3">
                            <label for="passKey2"> Confirm Password </label>
                            <input class="form-control" placeholder="Confirm Your Password *" 
                            type="password" name="passkey2" id="passKey2" required>
                        </div>
                        <div class="mt-3">
                            <?= csrf_token() ?>
                            <button type="submit" class="btn btn-lg rounded-3 btn-main w-100"> Create Account </button>
                        </div>
                    </form>
					<?php } ?>
                </div>
            </main>
        </div>
    </div>
</section>
<?php include_once(LAYOUTS_DIR."/footer.inc.php"); ?>