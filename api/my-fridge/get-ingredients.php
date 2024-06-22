<?php

declare(strict_types=1);
session_start();

global $pdo;

$user = $_SESSION['user'] ?? "";

if (!$user) send_response(["error" => "unauthorized"], 401);

$stmt = $pdo->prepare('SELECT fi.amount, fi.unit, fi.`ingredient_id`, i.label FROM `fridge_ingredients` fi LEFT JOIN `ingredients` i ON fi.`ingredient_id` = i.`ingredient_id` WHERE `account_id` = ?');
$stmt->execute([$user->id]);

$ingredients = $stmt->fetchAll(PDO::FETCH_OBJ);

send_response([
    "ingredients" => $ingredients
]);

