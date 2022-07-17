<?php
require_once("../bootstrap/autoload.php");

$errors   = array();
$messages = array();

if(Forms::isPost() && Forms::assertPost("editProfileFormSet"))
{
    $firstName = Forms::getPost("first_name");
    $lastName  = Forms::getPost("last_name");
    $mobile    = Forms::getPost("mobile");

    if(empty($errors)){
        $userObj = new Users();
        $userID      = Session::get("user")["id"];
        $updateSet   =  array(
            "firstName" => $firstName,
            "lastName"  => $lastName,
            "mobile"     => $mobile,
        );
        if($userObj->update($userID, $updateSet))
        {
            $messages[] = "Your profile has been updated";
            Helper::redirectTo(2);
        }
    }
}

if(Forms::isPost() && Forms::assertPost("changePasswordFormSet"))
{
    $userObj =  new Users();
    $oldPsw   = Forms::getPost("old_password");
    $newPsw   = Forms::getPost("new_password1");
    $cNewPsw  = Forms::getPost("new_password2");
    $userID   = Session::get("user")["id"];

    if(empty($oldPsw) || empty($newPsw) || empty($cNewPsw)){
        $errors[] = "Fields cannot be empty";
    }

    if($newPsw != $cNewPsw){
        $errors[] = "Passwords do not match";
    }
    
    if(strlen($newPsw) < 8){
        $errors[] = "Password Must be @least 8 characters";
    }
    
    $get_old_password = $userObj->fetchUserPassword($userID);
    if(!password_verify($oldPsw, $get_old_password)){
        $errors[] = "old password was incorrect!";
    }
    
    if(empty($errors)){
        $updateSet   =  array(
            "password"  => Forms::encryptPsw($newPsw)
        );
        if($userObj->update($userID, $updateSet))
        {
            $messages[] = "Your password has been changed";
            Helper::redirectTo(2);
        }
    }
}


require_once(LAYOUTS_DIR."/user_header.inc.php");

$userProfile = $meObj->fetchUserById(Session::get("user")["id"]);
?>
    <main class="container">
        <div class="bg-light p-5 rounded mt-3">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
            <a class="btn btn-lg btn-primary rounded-5" href="#changePasswordModal" data-bs-toggle="modal">
                <span class="bi bi-pen"></span> Change Password
            </a>
        </div>
        <?= Helper::displayMessages(Session::get("msg")); ?>
        <?= Helper::displaySuccesses($messages); ?>
        <?= Helper::displayErrors($errors); ?>
    </main>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">     
            <div class="col-md-8 mb-4 mb-md-0">
                <div class="card card-body mb-5">
                    <form action="<?= Forms::postToSelf() ?>" method="POST">
                        <div class="row">
                            <div class="mb-3 col-sm-6">
                                <label for="id_first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Your First Name e.g John" 
                                maxlength="150" required id="id_name" <?= Forms::stickyTextEdit($userProfile["firstName"], "first_name") ?>>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="id_last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Your Last Name e.g Doe" maxlength="150" 
                                required id="id_name" <?= Forms::stickyTextEdit($userProfile["lastName"], "last_name") ?>>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="id_email">Email Address:</label>
                                <input type="email" name="email" class="form-control" placeholder="Your Email" maxlength="100" 
                                required id="id_email" readonly <?= Forms::stickyTextEdit($userProfile["email"], "email") ?>>
                                <small class="help-text">Not editable</span></small>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="id_mobile">Phone Number:</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile Phone Number" 
                                maxlength="20" required id="id_mobile" <?= Forms::stickyTextEdit($userProfile["mobile"], "mobile") ?>>
                            </div>
                            <div class="my-2 col-12">
                                <input type="hidden" name="editProfileFormSet" value="aet42LJpZ8URIXDWHmF0foWLelNtk2lwDvQbXuO1PD7TWojmbrxkrk8MlT1N4RVx">
                                <button type="submit" class="btn btn-lg btn-primary rounded-5 w-100">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-body bg-100">
                    <p class="lead">
                        <strong class="text-warning">Warning!!!</strong><br>
                        Delete Your Account
                    </p>
                    <a href="#deleteAccountModal" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal">
                        <span class="bi bi-trash"></span> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--change password modal-->
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Your Password</h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <input type="hidden" name="changePasswordFormSet" value="aet42LJpZ8URIXDWHmF0foWLelNtk2lwDvQbXuO1PD7TWojmbrxkrk8MlT1N4RVx">
                    <div class="form-group mb-3">
                            <label for="id_old_password" class="form-label">
                                Old Password
                            </label>
                            <input type="password" name="old_password" placeholder="Enter New password" class="form-control" required id="id_old_password">
                        </div>
                    <div class="form-group mb-3">
                            <label for="id_new_password1" class="form-label">
                                New Password
                            </label>
                            <input type="password" name="new_password1" placeholder="Enter New password" class="form-control" required id="id_new_password1">
                        </div>
                    <div class="form-group mb-3">
                        <label for="id_new_password2" class="form-label">
                            Confirm Password
                        </label>
                        <input type="password" name="new_password2" placeholder="Confirm password" class="form-control" required id="id_new_password2">
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteAccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Close Your Account?</h4>
            </div>
            <div class="modal-body">
                <form action="<? Forms::postToSelf() ?>" method="POST">
                    <p>Are you sure you want to close your account?</p>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-danger">Close Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>