<?php

session_start();

global $pdo;

$user = $_SESSION['user'] ?? '';

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$id = $data['id'] ?? '';

if (!$id) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('SELECT r.`creator_id`, r.`title`, r.`description`, r.`estimate_price`, r.`estimate_time`, r.`estimate_price`, c.`value` AS category FROM `recipes` r LEFT JOIN `categories` c ON r.`category_id` = c.`category_id` WHERE `recipe_id` = ?');
$stmt->execute([$id]);

$recipe = $stmt->fetch(PDO::FETCH_OBJ);

if (!isAdmin() && $recipe->creator_id !== $user->id) send_response(["error" => "unauthorized"], 401);

$stmt = $pdo->prepare('SELECT ri.`unit`, ri.`amount`, i.`label`, i.`ingredient_id` from `recipe_ingredients` ri LEFT JOIN `ingredients` i ON ri.`ingredient_id` = i.`ingredient_id` WHERE ri.`recipe_id` = ?');
$stmt->execute([$id]);

$recipe->ingredients = $stmt->fetchAll(PDO::FETCH_OBJ);

$recipe->images = [];

$images = getAllRecipeImageNames($id);

foreach ($images as $image) {
    $recipe->images[] = [
        "src" => BASE_URL . "/images/$id/$image",
        "fileName" => $image
    ];
}

send_response(
    ["recipe" => $recipe]
);

