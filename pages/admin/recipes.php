<?php

global $pdo;

$stmt = $pdo->prepare('SELECT * FROM `recipes` WHERE `is_pending` = 0 AND `is_denied` = 0');
$stmt->execute();

$recipes = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="d-flex gap-2 flex-column">
    <h2>Recipes</h2>

    <div id="recipes-container" class="row" style="flex: 0.7">
        <?php foreach ($recipes as $recipe) : ?>
            <div id="recipe-<?=$recipe->recipe_id?>" class="col-sm-6 col-md-6 col-xl-4 align-items-stretch recipe-card" style="margin-bottom: 24px">
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

                            <div class="d-flex gap-2 align-items-center">
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
</div>

<script src="<?=BASE_URL?>/assets/js/admin/recipes.js"></script>
