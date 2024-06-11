<?php

global $pdo;

// probably a better way of doing this?

$stmtRecipeRequestsCount = $pdo->prepare("SELECT COUNT(*) FROM recipes WHERE `is_pending` = 1");
$stmtRecipeCount = $pdo->prepare("SELECT COUNT(*) FROM recipes WHERE `is_pending` = 0");
$stmtCategoriesCount = $pdo->prepare("SELECT COUNT(*) FROM `categories`");
$stmtIngredientsCount = $pdo->prepare("SELECT COUNT(*) FROM `ingredients`");
$stmtAccountsCount = $pdo->prepare("SELECT COUNT(*) FROM `accounts` WHERE `is_banned` = 0");
$stmtBannedAccountsCount = $pdo->prepare("SELECT COUNT(*) FROM `accounts` WHERE `is_banned` = 1");

$stmtRecipeRequestsCount->execute();
$stmtRecipeCount->execute();
$stmtCategoriesCount->execute();
$stmtIngredientsCount->execute();
$stmtAccountsCount->execute();
$stmtBannedAccountsCount->execute();

$recipeRequestsCount = $stmtRecipeRequestsCount->fetchColumn(0);
$recipeCount = $stmtRecipeCount->fetchColumn(0);
$categoriesCount = $stmtCategoriesCount->fetchColumn(0);
$ingredientsCount = $stmtIngredientsCount->fetchColumn(0);
$accountsCount = $stmtAccountsCount->fetchColumn(0);
$bannedAccountsCount = $stmtBannedAccountsCount->fetchColumn(0);

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