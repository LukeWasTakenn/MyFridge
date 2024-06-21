<?php

declare(strict_types=1);
session_start();

global $pdo;

$user = $_SESSION['user'];

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$recipeData = $data['recipe'];

$ingredients = $recipeData['ingredients'];
$images = $recipeData['images'];

if (count($ingredients) < 1) send_response(["error" => "Must have at least 1 ingredient."]);
if (count($images) < 1) send_response(["error" => "Must have at least 1 image."]);

$stmt = $pdo->prepare('SELECT `category_id` FROM `categories` WHERE `value` = ?');
$stmt->execute([$recipeData['category'] ?? ""]);

$category_id = $stmt->fetchColumn(0);

if (!isset($category_id)) send_response(["error" => "No such category"], 500);

$recipe = new Recipe(
    $user->id,
    $category_id,
    $recipeData['name'],
    json_encode($recipeData['description']),
    (int) $recipeData['cookTime'],
    (int) $recipeData['costEstimate'],
    $recipeData['ingredients'],
    $recipeData['images']
);

if (!$recipe->validate()) send_response(["error" => "There was an error validating the request."]);

$id = $recipe->create();

if (!$id) {
    send_response(["error" => "Something went wrong creating the recipe"]);
}

send_response([
    "id" => $id
]);