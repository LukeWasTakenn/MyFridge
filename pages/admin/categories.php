<?php

?>

<div class="d-flex gap-2 flex-column">
    <h2>Categories</h2>

    <div class="d-flex gap-4 flex-column">
        <div class="d-flex flex-column flex-lg-row justify-content-lg-between gap-2 align-items-lg-center">
            <input id="categories-search" class="form-control" placeholder="Search..." style="flex: 0.3"/>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                <i class="ti ti-plus"></i>
                New category
            </button>
        </div>

        <div class="d-flex flex-column gap-2" id="category-items">

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
                    <label for="modal-edit-name">Category name</label>
                    <input id="modal-edit-name" class="form-control"/>
                    <span id="modal-edit-name-error" class="text-danger error"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="modal-confirm-edit" type="button" class="btn btn-primary" onclick="handleEditCategory()">Confirm</button>
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
                    <label for="modal-new-name">Category name</label>
                    <input id="modal-new-name" class="form-control"/>
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