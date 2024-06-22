<?php

require base_path('includes/header.php');

?>

<main id="container" class="container-fluid container-md min-vh-100 pt-4 d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-5">
        <h2>My Fridge</h2>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
            <i class="ti ti-plus"></i>
            Add ingredient
        </button>
    </div>

    <div class="d-flex gap-2 flex-column">
        <h4>Ingredients</h4>
        <div id="ingredient-cards" class="row m-0 gap-2">

        </div>
    </div>

    <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="add-ingredient-form" class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newCategoryModalLabel">Add ingredient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-2">
                    <div>
                        <label for="modal-ingredient-name">Ingredient name</label>
                        <div style="position: relative">
                            <input id="modal-ingredient-name" name="ingredientName" class="form-control"/>
                            <div id="autocomplete" class="autocomplete-container rounded p-2 flex-column border shadow">

                            </div>
                        </div>
                        <span id="ingredientName-error" class="text-danger error"></span>
                    </div>
                    <div>
                        <label for="modal-ingredient-amount">Amount</label>
                        <input name="ingredientAmount" id="modal-ingredient-amount" class="form-control"/>
                        <span id="ingredientAmount-error" class="text-danger error"></span>
                    </div>
                    <div>
                        <label for="modal-ingredient-unit">Unit</label>
                        <select name="ingredientUnit" id="modal-ingredient-unit" class="form-control">
                            <option selected value="-1">- Select a unit - </option>
                            <option value="count">Count</option>
                            <option value="liter">Liter</option>
                            <option value="gram">Gram</option>
                            <option value="kilogram">Kilogram</option>
                        </select>
                        <span id="ingredientUnit-error" class="text-danger error"></span>
                    </div>
                    <span id="form-error" class="text-danger error"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="new-category-confirm" type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/account/my-fridge.js"?>"></script>


<?php

require base_path('includes/footer.php');
