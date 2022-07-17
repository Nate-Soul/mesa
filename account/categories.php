<?php
require_once("../bootstrap/autoload.php");
Login::restrictUsers();

$categoriesObj = new Category();

$errors   = array();
$messages = array();

if(Forms::isPost() && Forms::assertPost("addCategoryFormSet")){

    $categoryName    = Forms::getPost("cartName");
    $categoryMeta    = Forms::getPost("metaTitle");
    $categoryContent = Forms::getPost("content");
    $token           = Forms::getPost("addCategoryFormSet");

    if(!Token::checkCSRFToken($token)){
        $errors[] = "Check your form and try again";
    } else {

        if(empty($categoryName)){
            $errors[] = "Category name cannot be empty";
        } else {

            if(strlen($categoryName) < 2 || strlen($categoryName) > 100){
                $errors[] = "Category name cannot be less than 2 or greater than 100";
            }
            
        }

    }
    if(empty($errors)){
        $data = array(null, $categoryName, 
                    Helper::slugify($categoryName), 
                    $categoryMeta, $categoryContent
                );
        if($categoriesObj->add($data)){
            $messages[] = "Category has been added";
            Helper::redirectTo(2);
        }   
    }

}

if(Forms::isPost() && Forms::assertPost("editCategoryFormSet")){

    $categoryName    = Forms::getPost("cartNameEdit");
    $categoryMeta    = Forms::getPost("metaTitleEdit");
    $categoryContent = Forms::getPost("contentEdit");
    $categorySlug    = Url::getParam("category");

    if(empty($categoryName) || empty($categorySlug)){
        $errors[] = "Required parameters are empty";
    }

    if(strlen($categoryName) < 2 || strlen($categoryName) > 100){
        $errors[] = "Category name cannot be less than 2 or greater than 100";
    }

    if(empty($errors)){
        $data = array("title" => $categoryName, 
                    "slug" => Helper::slugify($categoryName), 
                    "metaTitle" => $categoryMeta,
                    "content" => $categoryContent
                );
        if($categoriesObj->update($categorySlug, $data)){
            $messages[] = "Category has been Updated";
            Helper::redirectTo(2);
        }   
    }

}


if(Forms::isPost() && Forms::assertPost("deleteCategoryFormSet")){

    $categorySlug = Url::getParam("category");

    if(empty($categorySlug)){
        $errors[] = "Empty parameters sent to server";
    }
    if(empty($errors)){
        if($categoriesObj->delete($categorySlug))
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
            <a class="btn btn-lg btn-primary rounded-5" href="#addCategoryModal" role="button" data-bs-toggle="modal">
                <span class="bi bi-plus"></span> Add Category
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
                    <h2 class="fs-4 mb-5"> Manage Categories </h2>
                    <a href="#" class="btn btn-danger d-none">Deleted Selected <span class="bi bi-trash"></span></a>
                </div>
                <table class="table table-striped fs-6">
                    <thead class="text-uppercase">
                        <th><input type="checkbox"></th>
                        <th>Category Name</th>
                        <th>Category Safe URL</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <?php 
                        $categories = $categoriesObj->read();
                        if($categories){
                    ?>
                    <tbody>
                        <?php
                            foreach($categories as $category){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><?= $category["title"] ?></td>
                            <td><?= $category["slug"] ?></td>
                            <td>
                                <a href="#editCategoryModal<?= $category["id"]?>" data-bs-toggle="modal"
                                class="btn btn-sm btn-primary">
                                    <span class="bi bi-pen"></span> Edit
                                </a>
                            </td>
                            <td>
                                <a href="#deleteCategoryModal<?= $category["id"]?>" data-bs-toggle="modal"
                                class="btn btn-sm btn-danger">
                                    <span class="bi bi-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                        <?php 
                            include "./categories_modal.inc.php";
                            } unset($category); ?>
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


<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Add Category </h4>
            </div>
            <div class="modal-body">
                <form action="<?= Forms::postToSelf() ?>" method="POST">
                    <div class="form-group mb-3">
                        <label for="id_cartName" class="form-label">
                            Category Name
                        </label>
                        <input type="text" name="cartName" placeholder="Category Name" <?= Forms::stickyText("cartName") ?> 
                        class="form-control" id="id_cartName" required>
                    </div>
                    <div class="form-group mb-3">
                            <label for="id_metaTitle" class="form-label">
                                Meta 
                            </label>
                            <input type="text" name="metaTitle" placeholder="Category Meta Title" class="form-control" 
                            id="id_metaTitle" <?= Forms::stickyText("metaTitle") ?>>
                        </div>
                    <div class="form-group mb-3">
                        <label for="id_content" class="form-label">
                            Meta Description
                        </label>
                        <textarea name="content" placeholder="Category Meta Description" class="form-control" 
                        id="id_content" rows="2" cols="10"><?= Forms::stickyArea("content") ?></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                    <input type="hidden" name="addCategoryFormSet" value="<?= Token::generateCSRFToken() ?>">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>