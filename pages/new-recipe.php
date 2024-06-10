<?php

$HEADER_LINKS = [
    '<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />',
    '<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>',
    "<link href='" . BASE_URL .  "/assets/css/quill.override.css' rel='stylesheet'>",
];

require base_path('includes/header.php');
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
        </div>
        <form style="flex: 1" id="recipe-form">
            <div class="d-flex flex-column gap-4">
                <div class="d-flex flex-column">
                    <label for="recipe-name">Recipe name</label>
                    <input id="recipe-name" class="form-control"/>
                </div>
                <div class="d-flex flex-column">
                    <label for="cook-time">Cook time (minutes)</label>
                    <input id="cook-time" class="form-control"/>
                </div>
                <div class="d-flex flex-column">
                    <label for="cost-estimate">Estimated cost</label>
                    <input id="cost-estimate" class="form-control"/>
                </div>
                <div class="d-flex flex-column gap-2">
                    <label for="recipe-ingredients">Ingredients</label>
                    <div id="ingredients-fields" class="d-flex flex-column gap-2">

                    </div>
                    <button type="button" class="btn btn-secondary" onclick="handleAddIngredient();">
                        <i class="ti ti-plus"></i>
                        Add ingredient
                    </button>
                </div>
                <div class="d-flex flex-column">
                    <label for="recipe-images">Images</label>
                    <button type="button" class="btn btn-secondary" onclick="handleAddImage();">
                        <i class="ti ti-plus"></i>
                        Add image
                    </button>
                    <p class="text-secondary fs-7">First image will be used as the thumbnail</p>
                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="ti ti-send"></i>
                    Submit recipe
                </button>
            </div>
        </form>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/new-recipe.js"?>"></script>


<?php

require base_path('includes/footer.php');

