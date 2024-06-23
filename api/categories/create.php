<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$data = get_request_data();

$newCategory = $data['newCategory'];
$newCategory = htmlspecialchars($newCategory);

$stmt = $pdo->prepare("SELECT 1 FROM `categories` WHERE `value` = ?");
$stmt->execute([strtolower($newCategory)]);

if ($stmt->fetchColumn(0)) {
    send_response([
        "error" => "This category already exists."
    ]);
}

$stmt = $pdo->prepare("INSERT INTO `categories` (`label`, `value`) VALUES (?, ?)");
$success = $stmt->execute([$newCategory, strtolower($newCategory)]);

if (!$success) {
    send_response([
        "error" => "Unable to insert category."
    ]);
}


send_response([
    "success" => true
]);