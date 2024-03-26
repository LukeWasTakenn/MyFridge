<?php

$HEADER_LINKS = [
        "<script src='/assets/js/recipe.js'></script>"
];

include_once 'includes/header.php';

// todo: move to db
$categories = ["Breakfast", "Lunch", "Dinner", "Desert", "Appetizer", "Soup"];

?>


<main class="container-fluid container-md min-vh-100 pt-4">
    <div class="d-flex flex-1 flex-column flex-lg-row gap-5">
        <div class="shadow-sm d-flex gap-4 flex-column border p-4 rounded" style="height: fit-content; flex: 0.3;">
            <h4>Filters</h4>
            <input class="form-control" placeholder="Search..."/>
            <div>
                <p class="m-0">Categories</p>
                <div class="d-flex gap-2 flex-wrap">
                    <?php foreach($categories as $index => $category) : ?>
                        <div class="btn btn-secondary btn-sm recipe-category" id="category-<?=$index?>" onclick="handleClick(this)">
                            <?= $category ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    My Fridge <span class="text-secondary" data-bs-toggle="tooltip" data-bs-title="Only displays recipes which match ingredients set in your My Fridge page."><i class="ti ti-help"></i></span>
                </label>
            </div>
        </div>
            <div class="row" style="flex: 0.7">
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<?php

include_once 'includes/footer.php';
