<?php

require base_path('includes/header.php');

global $pdo;

$user = $_SESSION['user'] ?? "";

if ($user) {
    $stmt = $pdo->prepare('SELECT r.`title`, r.`recipe_id` FROM `recipe_bookmarks` rb LEFT JOIN `recipes` r ON rb.`recipe_id` = r.`recipe_id` WHERE rb.`account_id` = ?');
    $stmt->execute([$user->id]);

    $recipes = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>

<main id="container" class="container-fluid container-md min-vh-100 pt-4 d-flex flex-column">
    <?php if (!$user) die("Unauthorized");?>
    
    <h2 class="mb-5">Bookmarks</h2>

    <div id="recipes-container" class="row">
        <?php foreach ($recipes as $recipe) : ?>
            <div id="recipe-<?=$recipe->recipe_id?>" class="col-sm-6 col-md-4 align-items-stretch recipe-card" style="margin-bottom: 24px">
                <div class="card border shadow-sm h-100">
                    <div style="overflow: hidden; height: 285px;">
                        <img src="<?=BASE_URL?>/images/<?=$recipe->recipe_id?>/<?=getRecipeImageName($recipe->recipe_id)?>" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between gap-3">
                        <div>
                            <h5 class="card-title"><?=$recipe->title?></h5>
                            <div class="d-flex gap-3 flex-wrap-wrap">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="./recipe?id=<?=$recipe->recipe_id?>" class="btn btn-secondary btn-icon">
                                <i class="ti ti-eye"></i>
                            </a>

                            <button class="btn btn-danger btn-icon" onclick="handleRemoveBookmark(<?=$recipe->recipe_id?>)">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/account/bookmarks.js"?>"></script>

<?php

require base_path('includes/footer.php');

