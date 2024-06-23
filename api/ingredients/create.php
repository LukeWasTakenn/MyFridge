<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$data = get_request_data();

$newIngredient = $data['newIngredient'] ?? "";

$newIngredient = htmlspecialchars($newIngredient);

$stmt = $pdo->prepare("SELECT 1 FROM `ingredients` WHERE `label` = ?");
$stmt->execute([$newIngredient]);

if ($stmt->fetchColumn(0)) {
    send_response([
        "error" => "This ingredient already exists."
    ]);
}

$stmt = $pdo->prepare("INSERT INTO `ingredients` (`value`, `label`) VALUES (?, ?)");
$success = $stmt->execute([strtolower($newIngredient), $newIngredient]);

if (!$success) {
    send_response([
        "error" => "Unable to insert ingredient."
    ]);
}

send_response([
    "success" => true
]);