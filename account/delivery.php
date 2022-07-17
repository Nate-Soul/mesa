<?php
require_once("../bootstrap/autoload.php");
Login::restrictVendors();

$deliveryObj = new Delivery();
// die(var_dump(Session::get("csrf_token")));
$errors   = array();
$messages = array();

if(Forms::isPost() && Forms::assertPost("token")){

    $token           = Forms::getPost("token");
    $deliveryName    = Forms::getPost("deliveryName");
    $deliveryFee     = (float)Forms::getPost("deliveryFee");
    $timeFrame       = Forms::getPost("timeFrame");
    $active          = Forms::getPost("active");
    

    if(Token::checkCSRFToken($token)){

        if(!Forms::checkIfEmpty(array($deliveryName, $deliveryFee, $timeFrame)))
        {
            $errors[] = "Fields cannot be empty!";
        } else {
            if(strlen($deliveryName) < 2 || strlen($deliveryName) > 100){
                $errors[] = "delivery name cannot be less than 2 or greater than 100";
            }
            if(!is_float($deliveryFee)){
                $errors[] = "delivery fee must me a decimal";
            }
        }

    } else {
        $errors[] = "Something went wrong, try reloading the form";
    }

    if(empty($errors)){
        $data = array(
                    $deliveryName,
                    $deliveryFee,
                    $timeFrame,
                    $active
                );
        if($deliveryObj->add($data)){
            $messages[] = "Delivery Option has been added";
            Helper::redirectTo(2);
        }   
    }

}

if(Forms::isPost() && Forms::assertPost("editDeliveryFormSet"))
{

    $token           = Forms::getPost("editDeliveryFormSet");
    $deliveryName    = Forms::getPost("deliveryName");
    $deliveryFee     = Forms::getPost("deliveryFee");
    $timeFrame       = Forms::getPost("timeFrame");
    $active          = Forms::getPost("active");
    $id              = (int)Url::getParam("delivery");

    //die($token. " equals ". Session::get("csrf_token"));

    if(Token::checkCSRFToken($token)){
        if(!Forms::checkIfEmpty(array($deliveryName, $deliveryFee, $timeFrame)))
        {
            $errors[] = "Fields cannot be empty!";
        } else {
            if(strlen($deliveryName) < 2 || strlen($deliveryName) > 100){
                $errors[] = "delivery name cannot be less than 2 or greater than 100";
            }
        }
    } else {
        $errors[] = "Something went wrong, try reloading the form";
    }

    if(empty($errors)){
        $data = array(
                    "name" => $deliveryName,
                    "fee" => $deliveryFee,
                    "timeFrame" => $timeFrame,
                    "isActive" => $active
                );
        if($deliveryObj->update($data, $id)){
            $messages[] = "Delivery Option has been updated";
            Helper::redirectTo(2);
        }   
    }

}


if(Forms::isPost() && Forms::assertPost("deleteDeliveryFormSet")){

    $deliveryID = (int)Url::getParam("delivery");
    $token      = Forms::getPost("deleteDeliveryFormSet");

    //die($token. " === ". Session::get("csrf_token")[0]);

    if(Token::checkCSRFToken($token)){
        if(empty($deliveryID)){
            $errors[] = "Empty parameters sent to server";
        } else {
            if(!is_numeric($deliveryID)){
                $errors[] = "Suspicious activity there";
            }
        }
    } else {
        $errors[] = "Something went wrong! try reloading the form";
    }
    if(empty($errors)){
        if($deliveryObj->delete($deliveryID))
        {
            $messages[] = "Category deleted";
            Helper::redirectTo(2);
        }
    }
}

require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <main class="container-fluid">
        <div class="bg-light p-3 rounded">
            <a class="btn btn-lg btn-default rounded-5" href="<?= DASHBOARD_URL ?>" role="button">
                <span class="bi bi-chevron-double-left"></span> Back to Dashboard
            </a>
            <a class="btn btn-lg btn-primary rounded-5" href="#addDeliveryModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add Delivery
            </a>
        </div>
        <?= 
            Helper::displayErrors($errors);
            Helper::displaySuccesses($messages);
            Helper::displayMessages(Session::get("msg"));
        ?>
    </main>
</header>
<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <main class="col-12">
                <div class="header d-flex justify-content-between align-items-start">
                    <h2 class="fs-4 mb-5"> Manage Delevery Options </h2>
                    <a href="#" class="btn btn-danger d-none">Deleted Selected <span class="bi bi-trash"></span></a>
                </div>
                <table class="table table-striped fs-6">
                    <thead class="text-uppercase">
                        <th><input type="checkbox"></th>
                        <th>Delivery Option</th>
                        <th>Delivery Fee</th>
                        <th>Time Frame</th>
                        <th>Active</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <?php 
                        $deliveries = $deliveryObj->readAll();
                        if($deliveries){
                    ?>
                    <tbody>
                        <?php
                            foreach($deliveries as $delivery){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><?= $delivery["name"] ?></td>
                            <td><?= $delivery["fee"] ?></td>
                            <td><?= $delivery["timeFrame"] ?></td>
                            <td><?= $delivery["isActive"] ?></td>
                            <td>
                                <a href="#editDeliveryModal<?= $delivery["id"]?>" data-bs-toggle="modal"
                                class="btn btn-sm btn-primary">
                                    <span class="bi bi-pen"></span> Edit
                                </a>
                            </td>
                            <td>
                                <a href="#deleteDeliveryModal<?= $delivery["id"]?>" data-bs-toggle="modal"
                                class="btn btn-sm btn-danger">
                                    <span class="bi bi-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                        <?php 
                            include "./deliveries_modal.inc.php";
                            } unset($delivery); ?>
                    </tbody>
                    <?php } else { ?>
                        <div class="alert alert-info">
                            No Categories yet! start adding categories.
                        </div>
                    <?php } ?>
                </table>
            </main>
        </div>
    </div>
</section>


<div class="modal fade" id="addDeliveryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Add Delivery Option </h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <div class="mb-3">
                        <label for="id_deliveryName" class="form-label">
                            Delivery Name
                        </label>
                        <input type="text" name="deliveryName" placeholder="Delivery Name" <?= Forms::stickyText("deliveryName") ?> 
                        class="form-control" id="id_deliveryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_deliveryFee" class="form-label">
                            Delivery Fee
                        </label>
                        <input type="text" name="deliveryFee" placeholder="Delivery Fee" class="form-control" 
                        id="id_deliveryFee" <?= Forms::stickyText("deliveryFee") ?> required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="id_timeFrame">Time Frame</label>
                        <input type="text" class="form-control" id="id_timeFrame" name="timeFrame" 
                        placeholder="Delivery Time Frame" <?= Forms::stickyText("timeFrame") ?> required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="active" id="active" class="form-check-input" <?= Forms::stickyCheck("active") ?>>
                        <label for="active" class="form-check-label">Set as active</label>
                    </div>
            </div>
            <div class="modal-footer">
                    <?= csrf_token() ?>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Add Delivery</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>