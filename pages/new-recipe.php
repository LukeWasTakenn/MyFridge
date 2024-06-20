<?php

$HEADER_LINKS = [
    '<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />',
    '<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>',
    "<link href='" . BASE_URL .  "/assets/css/quill.override.css' rel='stylesheet'>",
];

require base_path('includes/header.php');

global $pdo;

$stmt = $pdo->prepare('SELECT `label`, `value` FROM `categories`');
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<main id="container" class="container-fluid container-md min-vh-100 pt-0 pt-md-4 d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="m-0">Create a recipe</h2>
            <p class="fs-7 text-secondary">Share your culinary spark.</p>
        </div>
    </div>

    <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 gap-lg-5" style="flex: 1">
        <div class="d-flex flex-column" style="flex: 1; overflow: hidden">
            Recipe details
            <div id="editor" style="flex: 1">

            </div>
            <span id="recipeDetails-error" class="text-danger error"></span>
        </div>
        <form style="flex: 1" id="recipe-form">
            <div class="d-flex flex-column gap-4">
                <div class="d-flex flex-column">
                    <label for="recipe-name">Recipe name</label>
                    <input id="recipe-name" name="recipeName" class="form-control"/>
                    <span id="recipeName-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column">
                    <label for="recipe-category">Recipe category</label>
                    <select id="recipe-category" name="recipeCategory" class="form-control">
                        <option value="-1" selected>Select category</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?=$category->value?>"><?=$category->label?></option>
                        <?php endforeach;?>
                    </select>
                    <span id="recipeCategory-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column">
                    <label for="cook-time">Cook time (minutes)</label>
                    <input id="cook-time" name="cookTime" class="form-control"/>
                    <span id="cookTime-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column">
                    <label for="cost-estimate">Estimated cost</label>
                    <input id="cost-estimate" name="costEstimate" class="form-control"/>
                    <span id="costEstimate-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column gap-2">
                    <label for="recipe-ingredients">Ingredients</label>
                    <div id="ingredients-fields" class="d-flex flex-column gap-2">

                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                        <i class="ti ti-plus"></i>
                        Add ingredient
                    </button>
                    <span id="ingredients-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column">
                    <label for="recipe-images">Images</label>
                    <button type="button" class="btn btn-secondary" onclick="handleAddImage();">
                        <i class="ti ti-plus"></i>
                        Add image
                    </button>
                    <p class="text-secondary fs-7">First image will be used as the thumbnail</p>
                    <span id="ingredients-error" class="text-danger error"></span>
                </div>
                <button id="recipe-submit" class="btn btn-primary" type="submit">
                    <i class="ti ti-send"></i>
                    Submit recipe
                </button>
                <span id="recipe-form-error" class="text-danger error"></span>
            </div>
        </form>
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
<script src="<?=BASE_URL . "/assets/js/new-recipe.js"?>"></script>


<?php

require base_path('includes/footer.php');

