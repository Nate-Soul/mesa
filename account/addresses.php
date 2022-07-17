<?php
require_once("../bootstrap/autoload.php");

$countriesObj = new Countries();
$addressObj   = new Addresses();

$errors   = array();
$messages = array();

if(Forms::isPost() && Forms::assertPost("token"))
{
    $userID      = Session::get("user")["id"];
    $address_1   = Forms::getPost("address_line_1");
    $address_2   = Forms::getPost("address_line_2");
    $city        = Forms::getPost("city");
    $state       = Forms::getPost("state");
    $country     = Forms::getPost("country");
    $postalCode  = Forms::getPost("post_code");
    $note        = Forms::getPost("notes");
    $token       = Forms::getPost("token");

    echo $userID. " ".$token. " ".$address_1. " ".$city." ".$state. " ".$country. " ". $postalCode;
    if(Token::checkCSRFToken($token)){
        if(!Forms::checkIfEmpty(array($userID, $address_1, $city, $state, $country, $postalCode))){
            $errors[] = "Required fields cannot be empty";
        } else {
            if(!is_numeric($postalCode)){
                $errors[] = "Postal code can only be numbers";
            }
        }
    } else {
        $errors[] = "Something went wrong, try reloading the form";
    }
    if(empty($errors)){
        //unset default addresses first
        if($addressObj->getUserAddressesCount($userID) > 0){
            $addressObj->unsetUserDefaultAddress($userID);
        }
        //insert new address
        $insertData  =  array($userID, $address_1, 
                            $address_2, $city, $state, 
                            $country, $postalCode, $note, true
                        );
                        //die(var_dump($insertData));
        if($addressObj->create($insertData))
        {
            $messages[] = "You added a new address";
            Helper::redirectTo(2);
        }
    }
}

if(Forms::isPost() && Forms::assertPost("setDefaultAddressFormSet")){
    $userID    = Session::get("user")["id"];
    $addressID = Forms::getPost("setDefaultAddressFormSet");
    if(empty($userID) || empty($addressID)){
        $errors[] = "Empty parameters sent to server";
    }
    if(empty($errors)){
        if($addressObj->getUserAddressesCount($userID) > 0){
            $addressObj->unsetUserDefaultAddress($userID);
        }
        if($addressObj->setUserDefaultAddress($addressID, $userID))
        {
            $messages[] = "You've set a default address";
            Helper::redirectTo(2);
        }
    }
}

if(Forms::isPost() && Forms::assertPost("deleteAddressFormSet")){
    $userID    = Session::get("user")["id"];
    $addressID = Forms::getPost("deleteAddressFormSet");
    if(empty($userID) || empty($addressID)){
        $errors[] = "Empty parameters sent to server";
    }
    if(empty($errors)){
        if($addressObj->deleteUserAddress($addressID, $userID))
        {
            $messages[] = "You've deleted an address";
            Helper::redirectTo(2);
        }
    }
}


if(Forms::isPost() && Forms::assertPost("editAddressFormSet")){
    
    //$userID      = Session::get("user")["id"];
    $addressID   = Forms::getPost("editAddressFormSet");
    $address_1   = Forms::getPost("address_line_1");
    $address_2   = Forms::getPost("address_line_2");
    $city        = Forms::getPost("city");
    $state       = Forms::getPost("state");
    $country     = Forms::getPost("country");
    $postalCode  = Forms::getPost("post_code");
    $note        = Forms::getPost("notes");

    if(empty($addressID) || empty($address_1) || empty($city || empty($state) || empty($country) || empty($postalCode))){
        $errors[] = "Required fields cannot be empty";
    }

    if(!is_numeric($postalCode)){
        $errors[] = "Postal code can only be numbers";
    }

    if(empty($errors)){
        //update address
        $updateSet  =  array(
                        "address_1" => $address_1,
                        "address_2" => $address_2, 
                        "city" => $city, 
                        "state" => $state,
                        "countryCode" => $country, 
                        "postalCode" => $postalCode, 
                        "note" => $note
                        );
        if($addressObj->updateUserAddress($addressID, $updateSet))
        {
            $messages[] = "Changes for address saved";
            Helper::redirectTo(2);
        }
    }
}


require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <main class="container">
        <div class="bg-light p-5 rounded mt-3">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
            <a class="btn btn-lg btn-primary rounded-5" href="#addAddressModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add Address
            </a>
        </div>
        <?= 
            Helper::displayMessages(Session::get("msg"));
            Helper::displaySuccesses($messages); 
        ?>
    </main>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">     
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-uppercase"> Your Addresses </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            Helper::displayErrors($errors);
                            $addresses = $meObj->fetchUserAddresses($_SESSION["user"]["id"]);
                            if(!empty($addresses)){
                            foreach($addresses as $address){
                            ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="dropdown text-end">
                                        <a class="dropdown-toggle no-icon" href="#" role="button" data-bs-toggle="dropdown">
                                        &vellip;
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php if(!$address["isDefault"]){ ?>
                                            <li>
                                                <a href="#setDefaultAddressModal<?= $address["id"] ?>" class="dropdown-item" data-bs-toggle="modal">
                                                <span class="bi bi-pin"></span> Set as default</a>
                                            </li>
                                            <?php } ?>
                                            <li>
                                                <a href="#editAddressModal<?= $address["id"] ?>" class="dropdown-item" data-bs-toggle="modal">
                                                    <span class="bi bi-pen"></span> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#delAddressModal<?= $address["id"] ?>" data-bs-toggle="modal"
                                                class="dropdown-item">
                                                    <span class="bi bi-trash"></span> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <address class="address p-3">
                                        <?= 
                                        $address["address_1"].", ".$address["address_2"].", "
                                        .$address["postalCode"].", ".$address["city"].", " 
                                        .$address["state"].", ".$address["name"]."."
                                        ?>
                                    </address>
                                    <div class="card-footer d-flex justify-content-end bg-white">
                                        <?php if($address["isDefault"]){ ?>
                                        <p class="text-primary me-2">Default <span class="bi bi-pin"></span></p>
                                        <?php } else { ?>
                                        <p>Other Address</p>
                                        <?php } ?>
                                        <?php include "addresses_modal.inc.php"; ?>
                                    </div>
                                </div>
                            </div>
                            <?php } unset($address); } else { ?>
                            <div class="alert alert-info">Start adding your addresses </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ADD ADDRESS MODAL -->
<div class="modal fade" id="addAddressModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Address</h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <div class="mb-3">
                        <label for="id_address_line_1">Address Line 1:</label>
                        <input type="text" name="address_line_1" placeholder="Enter street address" class="form-control" maxlength="100" id="id_address_line_1" <?= Forms::stickyText("address_line_1") ?> required>
                    </div>
                    <div class="mb-3">
                        <label for="id_address_line_2">Address Line 2:</label>
                        <input type="text" name="address_line_2" placeholder="Enter suite/apartment address" class="form-control" maxlength="100" id="id_address_line_2" <?=   FOrms::stickyText("address_line _2") ?>>
                    </div>
                    <div class="mb-3">
                        <label for="id_postCode">Post Code:</label>
                        <input type="number" name="post_code" class="form-control" placeholder="Enter post code" maxlength="6" id="id_postCode" <?= Forms::stickyText("post_code") ?> required>
                    </div>
                    <div class="mb-3">
                        <label for="id_city">City/Town:</label>
                        <input type="text" name="city" placeholder="Enter City or Town" class="form-control" maxlength="100" id="id_city"<?= Forms::stickyText("city") ?> required>
                    </div>
                    <div class="mb-3">
                        <label for="id_state">Province/State:</label>
                        <input type="text" name="state" placeholder="Enter state or province" class="form-control" maxlength="100" id="id_state" <?= Forms::stickyText("state") ?> required>
                    </div>
                    <div class="mb-3">
                        <label for="id_country">Country:</label>
                            <?= $countriesObj->getCountriesSelect(); ?>
                    </div>
                    <div class="mb-3">
                        <label for="id_notes">Delivery Instructions:</label>
                        <textarea name="notes" cols="40" rows="2" class="form-control" placeholder="Short Delivery Instruction here" maxlength="255" id="id_notes"><?= Forms::stickyArea("notes") ?> </textarea>
                    </div>
            </div>
            <div class="modal-footer">
                    <?= csrf_token() ?>
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-primary">Add Address</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>