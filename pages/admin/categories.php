<?php

global $pdo;

$stmt = $pdo->prepare('SELECT * FROM `categories`');
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="d-flex gap-2 flex-column">
    <h2>Categories</h2>

    <div class="d-flex gap-4 flex-column">
        <div class="d-flex justify-content-between align-items-center">
            <input class="form-control" placeholder="Search..." style="flex: 0.3"/>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                <i class="ti ti-plus"></i>
                New category
            </button>
        </div>

        <div class="d-flex flex-column gap-2" id="category-items" style="">
            <?php foreach ($categories as $category) : ?>
                <div id="category-<?=$category->category_id?>" class="category-card shadow-sm">
                    <p><?=$category->name?></p>
                    <div class="d-flex gap-2 align-items-center">
                        <button class="btn btn-secondary btn-icon" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-bs-value="<?=$category->name?>">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-icon" onclick="handleDeleteCategory(<?=$category->category_id?>)">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach;?>
        </div>

    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCateryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCateryModalLabel">Edit category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="modal-new-name">Category name</label>
                    <input id="modal-new-name" class="form-control"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newCategoryModalLabel">New category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="modal-edit-name">Category name</label>
                    <input id="modal-edit-name" class="form-control"/>
                    <span id="category-error" class="text-danger error"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="new-category-confirm" type="button" class="btn btn-primary" onclick="handleCreateCategory();">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=BASE_URL?>/assets/js/utils.js"></script>
<script src="<?=BASE_URL?>/assets/js/admin/categories.js"></script>