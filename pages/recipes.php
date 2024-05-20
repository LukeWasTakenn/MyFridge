<?php

$jsString = "<script src='" . BASE_URL .  "/assets/js/recipe.js'></script>";

$HEADER_LINKS = [
    "<script src='" . BASE_URL .  "/assets/js/recipe.js'></script>"
];

require base_path('includes/header.php');

// todo: move to db
$categories = ["Breakfast", "Lunch", "Dinner", "Desert", "Appetizer", "Soup"];

$recipes = [
    [
        "name" => "Canadian style pancakes",
        "category" => "Desert",
        "image" => "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "time" => 25
    ],
    [
        "name" => "Pineapple Pizza",
        "category" => "Lunch",
        "image" => "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1981&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "time" => 40
    ],
    [
        "name" => "Sandwich with boiled egg",
        "category" => "Breakfast",
        "image" => "https://images.unsplash.com/photo-1482049016688-2d3e1b311543?q=80&w=2020&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "time" => 10
    ]
];

?>


<main class="container-fluid container-md min-vh-100 pt-0 pt-md-4">
    <div class="d-flex flex-1 flex-column flex-lg-row gap-5">
        <div class="shadow-sm d-flex gap-4 flex-column border p-4 rounded" style="height: fit-content; flex: 0.3;">
            <h4>Filters</h4>
            <input class="form-control" placeholder="Search..."/>
            <div>
                <p class="m-0">Categories</p>
                <div class="d-flex gap-2 flex-wrap">
                    <?php foreach ($categories as $index => $category) : ?>
                        <div class="btn btn-secondary btn-sm recipe-category" id="category-<?=$index?>" onclick="handleClick(this)">
                            <?= $category ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    My Fridge <span class="text-secondary" data-bs-toggle="tooltip" data-bs-title="Only displays recipes which closely match ingredients set in your My Fridge page."><i class="ti ti-help"></i></span>
                </label>
            </div>
        </div>
            <div class="row" style="flex: 0.7">
                <?php foreach ($recipes as $recipe) :?>
                    <div class="col-sm-6 col-md-4 mb-2 align-items-stretch">
                        <div class="card border shadow-sm h-100">
                            <div style="overflow: hidden; ">
                                <img src="<?= $recipe['image'] ?>" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between gap-3">
                                <div>
                                    <h5 class="card-title"><?= $recipe['name'] ?></h5>
                                    <div class="d-flex gap-3 flex-wrap-wrap">
                                        <span class="badge text-bg-primary"><?= $recipe['category'] ?></span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-clock text-primary"></i> <?= $recipe['time'] ?> min.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
</main>

<?php

require base_path('includes/footer.php');
