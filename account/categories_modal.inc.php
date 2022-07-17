<div class="modal fade" id="editCategoryModal<?= $category["id"] ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Edit Category </h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf() ?>?category=<?= $category["slug"] ?>" method="POST">
                    <input type="hidden" name="editCategoryFormSet" value="aet42LJpZ8URIXDWHmF0foWLelNtk2lwDvQbXuO1PD7TWojmbrxkrk8MlT1N4RVx">
                    <div class="form-group mb-3">
                        <label for="id_cartName" class="form-label">
                            Category Name
                        </label>
                        <input type="text" name="cartNameEdit" placeholder="Category Name" <?= Forms::stickyTextEdit($category["title"], "cartName") ?> 
                        class="form-control" id="id_cartName" required>
                    </div>
                    <div class="form-group mb-3">
                            <label for="id_metaTitle" class="form-label">
                                Meta 
                            </label>
                            <input type="text" name="metaTitleEdit" placeholder="Category Meta Title" class="form-control" 
                            id="id_metaTitle" <?= Forms::stickyTextEdit($category["metaTitle"], "metaTitle") ?>>
                        </div>
                    <div class="form-group mb-3">
                        <label for="id_content" class="form-label">
                            Meta Description
                        </label>
                        <textarea name="contentEdit" placeholder="Category Meta Description" class="form-control" 
                        id="id_content" rows="2" cols="10"><?= Forms::stickyAreaEdit($category["content"], "content") ?></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Edit Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--DELETE MODAL-->
<div class="modal fade" id="deleteCategoryModal<?= $category["id"] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-red-100">
                <form action="<?= Forms::postToSelf(); ?>?category=<?= $category["slug"] ?>" method="POST">
                    <input type="hidden" name="deleteCategoryFormSet" value="ughfwgkgbfgfhughgfghebgkteet">
                    <p>
                        Are you sure you want to delete this category?
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