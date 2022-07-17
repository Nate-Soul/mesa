<div class="modal fade" id="editDeliveryModal<?= $delivery["id"] ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Edit Delivery Option </h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf(2) ?>?delivery=<?= $delivery["id"] ?>" 
                method="POST" id="editDeliveryForm<?= $delivery["id"] ?>">
                    <div class="mb-3">
                        <label for="id_deliveryName<?= $delivery["id"] ?>" class="form-label">
                            Delivery Name
                        </label>
                        <input type="text" name="deliveryName" placeholder="Delivery Name" id="id_deliveryName<?= $delivery["id"] ?>" 
                        <?= Forms::stickyTextEdit($delivery["name"], "deliveryName") ?> class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_deliveryFee<?= $delivery["id"] ?>" class="form-label">
                            Delivery Fee
                        </label>
                        <input type="text" name="deliveryFee" placeholder="Delivery Fee" class="form-control" 
                        id="id_deliveryFee<?= $delivery["id"] ?>" <?= Forms::stickyTextEdit($delivery["fee"], "deliveryFee") ?> required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="id_timeFrame">Time Frame</label>
                        <input type="text" class="form-control" id="id_timeFrame<?= $delivery["id"] ?>" name="timeFrame" 
                        <?= Forms::stickyTextEdit($delivery["timeFrame"], "timeFrame") ?> required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="active" id="id_active<?= $delivery["id"] ?>" class="form-check-input" <?= Forms::stickyCheckEdit("active", $delivery["isActive"]) ?>>
                        <label for="id_active<?= $delivery["id"] ?>" class="form-check-label">Set as active</label>
                    </div>
            </div>
            <div class="modal-footer">
                    <?= csrf_token("editDeliveryFormSet") ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--DELETE MODAL-->
<div class="modal fade" id="deleteDeliveryModal<?= $delivery["id"] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-red-100">
                <form action="<?= Forms::postToSelf(2); ?>?delivery=<?= $delivery["id"] ?>" method="POST">
                    <p>
                        Are you sure you want to delete <?= $delivery["name"] ?>?
                    </p>
            </div>
            <div class="modal-footer bg-red-100">
                    <?= csrf_token("deleteDeliveryFormSet") ?>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>