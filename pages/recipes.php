<?php

global $pdo;

$HEADER_LINKS = [
    "<link href='" . BASE_URL .  "/assets/css/recipes.css' rel='stylesheet'>",
];

require base_path('includes/header.php');

$user = $_SESSION['user'] ?? '';

$stmt = $pdo->prepare('SELECT `label`, `category_id` FROM `categories`');
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $pdo->prepare('SELECT r.*, c.label AS `category` FROM `recipes` r LEFT JOIN `categories` c ON r.`category_id` = c.`category_id` WHERE `is_pending` = 0 AND `is_denied` = 0 ORDER BY r.`recipe_id` DESC');
$stmt->execute();

$recipes = $stmt->fetchAll(PDO::FETCH_OBJ);

?>


<main class="container-fluid container-md min-vh-100 pt-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-5">
        <div>
            <h2 class="m-0">Recipes</h2>
            <p class="fs-7 text-secondary">Find the perfect recipe for any occasion.</p>
        </div>
        <?php if ($user) : ?>
            <div>
                <a class="btn btn-secondary" href="<?=BASE_URL?>/new-recipe">
                    <i class="ti ti-plus"></i>
                    <span style="font-size: 14px;">Create a recipe</span>
                </a>
            </div>
        <?php endif;?>
    </div>
    <div class="d-flex flex-1 flex-column gap-3">
        <div class="d-flex flex-column-reverse flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <p>Categories</p>
                <div class="d-flex gap-2 flex-wrap">
                    <?php foreach ($categories as $index => $category) : ?>
                        <div class="btn btn-secondary btn-sm recipe-category" id="category-<?=$index?>" onclick="handleClick(this)" data-categoryId="<?=$category->category_id?>">
                            <?= $category->label ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <input id="recipe-search" class="form-control recipe-search" placeholder="Search..."/>
        </div>
        <?php if ($user) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    My Fridge <span class="text-secondary" data-bs-toggle="tooltip" data-bs-title="Only displays recipes which closely match ingredients set in your My Fridge page."><i class="ti ti-help"></i></span>
                </label>
            </div>
        <?php endif;?>
        <div id="recipes-container" class="row" style="flex: 0.7">

        </div>
        </div>
</main>

<script src="<?=BASE_URL?>/assets/js/utils.js"></script>
<script src="<?=BASE_URL?>/assets/js/recipes.js"></script>


<?php

require base_path('includes/footer.php');
