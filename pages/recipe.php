<?php
declare(strict_types=1);

$HEADER_LINKS = [
    '<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />',
    '<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>',
    "<link href='" . BASE_URL .  "/assets/css/quill.override.css' rel='stylesheet'>",
    "<link href='" . BASE_URL .  "/assets/css/recipe.css' rel='stylesheet'>",
];

require base_path('includes/header.php');

global $pdo;

$recipeId = $_GET['id'] ?? "";

$stmt = $pdo->prepare('SELECT r.*, c.label AS `category`, a.first_name, a.last_name FROM `recipes` r LEFT JOIN `categories` c ON r.`category_id` = c.`category_id` LEFT JOIN `accounts` a ON r.`creator_id` = a.`account_id` WHERE r.`recipe_id` = ?');
$stmt->execute([$recipeId]);

$recipe = $stmt->fetch(PDO::FETCH_OBJ);

?>


<main class="container-fluid container-md min-vh-100 pt-4">
    <?php if (!isset($recipe))
        die("No such recipe found.");
    ?>

    <h2 class="mb-5"><?=$recipe->title?></h2>

    <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 gap-lg-5" style="flex: 1">
        <div class="d-flex flex-column" style="flex: 1; overflow: hidden">
            <div id="editor" style="flex: 1">

            </div>
        </div>

        <div style="flex: 1" class="d-flex flex-column gap-3">
            <?php if ($recipe->is_pending || $recipe->is_denied) : ?>
                <div class="card">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <p>Status</p>
                        <i class="ti ti-activity"></i>
                    </div>
                    <h2>
                        <?php if ($recipe->is_pending && !$recipe->is_denied) : ?>
                            Pending
                        <?php else : ?>
                            Denied
                        <?php endif;?>
                    </h2>
                </div>
            <?php endif;?>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Author</p>
                    <i class="ti ti-user"></i>
                </div>
                <h2><?=$recipe->first_name?> <?=$recipe->last_name?></h2>
            </div>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Category</p>
                    <i class="ti ti-category"></i>
                </div>
                <h2><?=$recipe->category?></h2>
            </div>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Estimated time</p>
                    <i class="ti ti-clock"></i>
                </div>
                <h2><?=$recipe->estimate_time?> minutes</h2>
            </div>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Estimated cost</p>
                    <i class="ti ti-currency-dollar"></i>
                </div>
                <h2>$<?=$recipe->estimate_price?></h2>
            </div>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Ingredients</p>
                    <i class="ti ti-lemon-2"></i>
                </div>
                <p>- Tomato (3x count)</p>
                <p>- Tomato (3x count)</p>
                <p>- Tomato (3x count)</p>
            </div>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between text-secondary">
                    <p>Images</p>
                    <i class="ti ti-photo"></i>
                </div>
                ...
            </div>
        </div>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/recipe.js"?>"></script>


<?php

require base_path('includes/footer.php');

