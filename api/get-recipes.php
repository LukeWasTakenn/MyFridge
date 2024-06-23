<?php

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

send_response([
    "recipes" => $recipes
]);