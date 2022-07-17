<!--SET DEFAULT ADDRESS MODAL-->
<div class="modal fade" id="setDefaultAddressModal<?= $address["id"] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-light">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <input type="hidden" name="setDefaultAddressFormSet" value="<?= $address["id"] ?>">
                    <p>
                        Are you sure you want to set this address as default?
                    </p>
            </div>
            <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-info">Yes, Set as default</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--EDIT ADDRESS MODAL-->
<div class="modal fade" id="editAddressModal<?= $address["id"] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-red-100">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <input type="hidden" name="editAddressFormSet" value="<?= $address["id"] ?>">
                    <div class="mb-3">
                        <label for="id_address_line_1">Address Line 1:</label>
                        <input type="text" name="address_line_1" placeholder="Enter street address" class="form-control" 
                        maxlength="100" required id="id_address_line_1" <?= Forms::stickyTextEdit($address["address_1"], "address_line_1") ?>>
                    </div>
                    <div class="mb-3">
                        <label for="id_address_line_2">Address Line 2:</label>
                        <input type="text" name="address_line_2" placeholder="Enter suite/apartment address" class="form-control" placeholder="Suites/Apartment/Floor"
                        maxlength="100" id="id_address_line_2" <?= Forms::stickyTextEdit($address["address_2"], "address_line_2") ?>>
                    </div>
                    <div class="mb-3">
                        <label for="id_postcode">Post Code:</label>
                        <input type="text" name="post_code" class="form-control" placeholder="Enter post code" 
                        maxlength="6" required id="id_postcode" <?= Forms::stickyTextEdit($address["postalCode"], "post_code") ?>>
                    </div>
                    <div class="mb-3">
                        <label for="id_town">City/Town:</label>
                        <input type="text" name="city" placeholder="Your City/Town" class="form-control" 
                        maxlength="100" required id="id_town" <?= Forms::stickyTextEdit($address["city"], "city") ?>">
                    </div>
                    <div class="mb-3">
                        <label for="id_state">Province/State:</label>
                        <input type="text" name="state" placeholder="Enter state or province" class="form-control" 
                        maxlength="100" required id="id_state" <?= Forms::stickyTextEdit($address["state"], "state") ?>">
                    </div>
                    <div class="mb-3">
                        <label for="id_country">Country:</label>
                        <?= $countriesObj->getCountriesSelect($address["code"]); ?>
                    </div>
                    <div class="mb-3">
                        <label for="id_notes">Delivery Instructions:</label>
                        <textarea name="notes" cols="40" rows="2" class="form-control" placeholder="Short Delivery Instruction here" 
                        maxlength="255" id="id_notes"><?= Forms::stickyAreaEdit($address["note"], "notes") ?></textarea>
                    </div>
            </div>
            <div class="modal-footer bg-red-100">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--DELETE ADDRESS MODAL-->
<div class="modal fade" id="delAddressModal<?= $address["id"] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-red-100">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <input type="hidden" name="deleteAddressFormSet" value="<?= $address["id"] ?>">
                    <p>
                        Are you sure you want to delete this address?
                    </p>
            </div>
            <div class="modal-footer bg-red-100">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>