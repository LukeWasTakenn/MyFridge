<?php

require base_path('includes/header.php');

global $pdo;

$user = $_SESSION['user'] ?? '';

if ($user) {
    $stmt = $pdo->prepare('SELECT `recipe_id`, `title`, `is_pending`, `is_denied` FROM `recipes` WHERE `creator_id` = ? AND `is_denied` = 0');
    $stmt->execute([$user->id]);

    $recipes = $stmt->fetchAll(PDO::FETCH_OBJ);
}

?>

<main id="container" class="container-fluid container-md min-vh-100 pt-4 d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-5">
        <h2>My Recipes</h2>
        <a href="./new-recipe" class="btn btn-secondary">
            <i class="ti ti-plus"></i>
            New recipe
        </a>
    </div>

    <div id="recipes-container" class="row">
        <?php foreach ($recipes as $recipe) : ?>
            <div id="recipe-<?=$recipe->recipe_id?>" class="col-sm-6 col-md-4 align-items-stretch recipe-card" onclick="handleRecipeClick(${recipe.recipe_id});" style="margin-bottom: 24px">
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
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-danger btn-icon" onclick="handleDeleteRecipe(<?=$recipe->recipe_id?>)">
                                    <i class="ti ti-trash"></i>
                                </button>
                                <a href="./edit-recipe?id=<?=$recipe->recipe_id?>" class="btn btn-secondary btn-icon">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</main>

<script src="<?=BASE_URL?>/assets/js/account/my-recipes.js"></script>


<?php

require base_path('includes/footer.php');

