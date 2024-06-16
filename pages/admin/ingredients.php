<div class="d-flex gap-2 flex-column">
    <h2>Ingredients</h2>

    <div class="d-flex gap-4 flex-column">
        <div class="d-flex flex-column flex-lg-row justify-content-lg-between gap-2 align-items-lg-center">
            <input id="ingredients-search" class="form-control" placeholder="Search..." style="flex: 0.3"/>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                <i class="ti ti-plus"></i>
                New ingredient
            </button>
        </div>

        <div class="d-flex flex-column gap-2" id="ingredient-items">

        </div>

        <div class="modal fade" id="editIngredientModal" tabindex="-1" aria-labelledby="editIngredientModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form id="edit-ingredient-form" class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editIngredientModalLabel">Edit ingredient</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="modal-edit-name">Ingredient name</label>
                        <input id="modal-edit-name" class="form-control"/>
                        <span id="modal-new-name-error" class="text-danger error"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="modal-confirm-edit" type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
            <form id="new-ingredient-form" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newIngredientModalLabel">New ingredient</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="modal-new-name">Ingredient name</label>
                        <input id="modal-new-name" class="form-control"/>
                        <span id="ingredient-error" class="text-danger error"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="new-ingredient-confirm" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="<?=BASE_URL?>/assets/js/utils.js"></script>
<script src="<?=BASE_URL?>/assets/js/admin/ingredients.js"></script>