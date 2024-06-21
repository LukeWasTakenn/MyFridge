<?php

global $pdo;

$stmt = $pdo->prepare('SELECT r.*, c.label AS `category` FROM `recipes` r LEFT JOIN `categories` c ON r.`category_id` = c.`category_id` WHERE `is_pending` = 1');
$stmt->execute();

$recipes = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="d-flex gap-2 flex-column">
    <h2>Recipe requests</h2>

    <div class="row">
        <?php foreach ($recipes as $recipe) :?>
            <div id="recipe-<?=$recipe->recipe_id?>" class="col-sm-6 col-md-4 align-items-stretch recipe-card" style="margin-bottom: 24px">
                <div class="card border shadow-sm h-100">
                    <div style="overflow: hidden; height: 285px;">
                        <img src="<?=BASE_URL?>/images/<?=$recipe->recipe_id?>/<?=getRecipeImageName($recipe->recipe_id)?>" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between gap-3">
                        <div>
                            <h5 class="card-title"><?= $recipe->title ?></h5>
                            <div class="d-flex gap-3 flex-wrap-wrap">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="./recipe?id=<?=$recipe->recipe_id?>" class="btn btn-secondary btn-icon">
                                <i class="ti ti-eye"></i>
                            </a>
                            <div class="d-flex gap-2 align-items-center">
                                <button class="btn btn-secondary btn-icon" onclick="handleDenyRecipe(<?=$recipe->recipe_id?>);">
                                    <i class="ti ti-x"></i>
                                </button>
                                <button class="btn btn-primary btn-icon" onclick="handleAcceptRecipe(<?=$recipe->recipe_id?>);">
                                    <i class="ti ti-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?=BASE_URL?>/assets/js/utils.js"></script>
<script src="<?=BASE_URL?>/assets/js/admin/recipe-requests.js"></script>
