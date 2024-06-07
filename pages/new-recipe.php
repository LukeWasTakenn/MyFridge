<?php

$HEADER_LINKS = [
    '<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />',
    '<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>',
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

    <div class="d-flex justify-content-between gap-5" style="flex: 1">
        <div class="d-flex flex-column" style="flex: 1; overflow: hidden">
            Recipe details
            <div id="editor">
                <p>Hello World!</p>
                <p>Some initial <strong>bold</strong> text</p>
                <p><br /></p>
            </div>
        </div>
        <div style="flex: 1">
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
                    <label for="recipe-ingredients">Ingredients</label>
                    <button class="btn btn-light">
                        <i class="ti ti-plus"></i>
                        Add ingredient
                    </button>
                </div>
                <div class="d-flex flex-column">
                    <label for="recipe-images">Images</label>
                    <button class="btn btn-light">
                        <i class="ti ti-plus"></i>
                        Add image
                    </button>
                </div>
                <button class="btn btn-primary">
                    <i class="ti ti-send"></i>
                    Submit recipe
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        bounds: document.getElementById("container")
    })
</script>

<?php

require base_path('includes/footer.php');

