<?php

session_start();

global $pdo;

$data = get_request_data();

$categoryId = $data['category'] ?? "";
$search = $data['search'] ?? "";
$myFridge = $data['myFridge'] ?? "";

$stmt = $pdo->prepare('SELECT `label`, `category_id` FROM `categories`');
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);

$categoryQuery = "";
if ($categoryId) {
    $categoryQuery = "AND c.`category_id` = ?";
}

$search = "%$search%";

$params = $categoryId ? [$search, $categoryId] : [$search];

$stmt = $pdo->prepare('SELECT r.*, c.label AS `category` FROM `recipes` r LEFT JOIN `categories` c ON r.`category_id` = c.`category_id` WHERE `is_pending` = 0 AND `is_denied` = 0 AND r.`title` LIKE ? ' . $categoryQuery . ' ORDER BY r.`recipe_id` DESC');
$stmt->execute($params);

$recipes = $stmt->fetchAll(PDO::FETCH_OBJ);

for ($i = 0; $i < count($recipes); $i++) {
    $image = getRecipeImageName($recipes[$i]->recipe_id);

    $recipes[$i]->image = BASE_URL . "/images/{$recipes[$i]->recipe_id}/$image";
}

if (!$myFridge) send_response(["recipes" => $recipes]);

$user = $_SESSION['user'] ?? '';

if (!$user) send_response(["error" => "unauthorized"], 401);

$stmt = $pdo->prepare('SELECT fi.`amount`, fi.`unit`, fi.`ingredient_id` FROM `fridge_ingredients` fi LEFT JOIN `ingredients` i ON fi.`ingredient_id` = i.`ingredient_id` WHERE fi.`account_id` = ?');
$stmt->execute([$user->id]);

$ingredients = $stmt->fetchAll(PDO::FETCH_OBJ);
$fridgeIngredients = [];

foreach ($ingredients as $ingredient) {
    $fridgeIngredients["$ingredient->ingredient_id"] = [
        "amount" => $ingredient->amount,
        "unit" => $ingredient->unit
    ];
}

$filteredRecipes = [];
$stmt = $pdo->prepare('SELECT ri.`amount`, ri.`unit`, i.label, i.`ingredient_id` FROM recipes r LEFT JOIN `recipe_ingredients` ri ON r.`recipe_id` = ri.`recipe_id` LEFT JOIN `ingredients` i ON ri.`ingredient_id` = i.`ingredient_id` WHERE r.`recipe_id` = ?');
foreach ($recipes as $recipe) {
    $stmt->execute([$recipe->recipe_id]);

    $ingredients = $stmt->fetchAll(PDO::FETCH_OBJ);

    $missingCount = 0;
    $missingIngredients = [];
    foreach ($ingredients as $ingredient) {
        if ($missingCount > 2) break;

        if (!isset($fridgeIngredients[$ingredient->ingredient_id])) {
            $missingCount++;
            $missingIngredients[] = $ingredient->label;
            continue;
        }

        $fridgeIngredient = $fridgeIngredients[$ingredient->ingredient_id];

        if (($ingredient->unit === 'kilogram' || $ingredient->unit === 'gram') && ($fridgeIngredient['unit'] === 'kilogram' || $fridgeIngredient['unit'] === 'gram')) {
            $requiredAmount = $ingredient->unit === 'kilogram' ? $ingredient->amount * 1000 : $ingredient->amount;
            $currentAmount = $fridgeIngredient['unit'] === 'kilogram' ? $fridgeIngredient['amount'] * 1000 : $fridgeIngredient['amount'];

            if ($currentAmount < $requiredAmount) {
                $missingCount++;
                $missingIngredients[] = $ingredient->label;
                continue;
            }
        }

        if (($ingredient->unit === 'liter' || $ingredient->unit === 'milliliter') && ($fridgeIngredient['unit'] === 'liter' || $fridgeIngredient['unit'] === 'milliliter')) {
            $requiredAmount = $ingredient->unit === 'liter' ? $ingredient->amount * 1000 : $ingredient->amount;
            $currentAmount = $fridgeIngredient['unit'] === 'liter' ? $fridgeIngredient['amount'] * 1000 : $fridgeIngredient['amount'];

            if ($currentAmount < $requiredAmount) {
                $missingCount++;
                $missingIngredients[] = $ingredient->label;
                continue;
            }
        }

        if ($ingredient->unit === 'count' && $ingredient->amount > $fridgeIngredient['amount']) {
            $missingCount++;
            $missingIngredients[] = $ingredient->label;
        }
    }

    if ($missingCount > 2) continue;

    if (count($missingIngredients) > 0) {
        $recipe->missing = $missingIngredients;
    }


    $filteredRecipes[] = $recipe;
}

send_response([
    "recipes" => $filteredRecipes
]);