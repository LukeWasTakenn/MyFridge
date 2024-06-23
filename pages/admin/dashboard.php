<?php

global $pdo;

$stmtCounts = $pdo->prepare("
    SELECT 
        (SELECT COUNT(*) FROM recipes WHERE `is_pending` = 1) AS recipe_requests_count,
        (SELECT COUNT(*) FROM recipes WHERE `is_pending` = 0 AND `is_denied` = 0) AS recipe_count,
        (SELECT COUNT(*) FROM `categories`) AS categories_count,
        (SELECT COUNT(*) FROM `ingredients`) AS ingredients_count,
        (SELECT COUNT(*) FROM `accounts` WHERE `is_banned` = 0) AS accounts_count,
        (SELECT COUNT(*) FROM `accounts` WHERE `is_banned` = 1) AS banned_accounts_count
");

$stmtCounts->execute();

$counts = $stmtCounts->fetch(PDO::FETCH_ASSOC);

$recipeRequestsCount = $counts['recipe_requests_count'];
$recipeCount = $counts['recipe_count'];
$categoriesCount = $counts['categories_count'];
$ingredientsCount = $counts['ingredients_count'];
$accountsCount = $counts['accounts_count'];
$bannedAccountsCount = $counts['banned_accounts_count'];


?>

<div class="d-flex gap-2 flex-column">
    <h2>Dashboard</h2>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Recipe requests</p>
            <i class="ti ti-send"></i>
        </div>
        <h2><?=$recipeRequestsCount?></h2>
    </div>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Recipes</p>
            <i class="ti ti-book"></i>
        </div>
        <h2><?=$recipeCount?></h2>
    </div>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Categories</p>
            <i class="ti ti-category"></i>
        </div>
        <h2><?=$categoriesCount?></h2>
    </div>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Ingredients</p>
            <i class="ti ti-lemon-2"></i>
        </div>
        <h2><?=$ingredientsCount?></h2>
    </div>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Accounts</p>
            <i class="ti ti-users"></i>
        </div>
        <h2><?=$accountsCount?></h2>
    </div>
    <div class="dashboard-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center text-secondary">
            <p>Banned accounts</p>
            <i class="ti ti-forbid"></i>
        </div>
        <h2><?=$bannedAccountsCount?></h2>
    </div>
</div>