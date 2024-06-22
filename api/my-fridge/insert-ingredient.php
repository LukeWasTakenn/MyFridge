<?php

declare(strict_types=1);
session_start();

global $pdo;

$user = $_SESSION['user'] ?? "";

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$ingredient = $data['ingredient'] ?? "";

if (!$ingredient) send_response(["error" => "invalid inputs"], 500);

$name = $ingredient['name'] ?? "";
$amount = $ingredient['amount'] ?? "";
$unit = $ingredient["unit"] ?? "";

if (!$name || !$amount || !$unit) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('SELECT `ingredient_id` FROM `ingredients` WHERE `value` = ?');
$stmt->execute([strtolower($name)]);

$ingredientId = $stmt->fetchColumn(0);

if (!$ingredientId) send_response(["error" => "No such ingredient"]);

$stmt = $pdo->prepare("SELECT 1 FROM `fridge_ingredients` WHERE `account_id` = ? AND `ingredient_id` = ?");
$stmt->execute([$user->id, $ingredientId]);

$hasIngredient = $stmt->fetchColumn(0);

if ($hasIngredient) send_response(["error" => "Ingredient is already in the fridge."]);

$stmt = $pdo->prepare('INSERT INTO `fridge_ingredients` (`account_id`, `ingredient_id`, `amount`, `unit`) VALUES (?, ?, ?, ?)');
$success = $stmt->execute([$user->id, $ingredientId, $amount, $unit]);

if (!$success) send_response(["error" => "Something went wrong"]);

send_response([
    "id" => $pdo->lastInsertId()
]);