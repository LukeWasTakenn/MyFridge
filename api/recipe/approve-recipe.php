<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$id = $data['recipeId'] ?? '';

if (!$id) send_response(["error" => "invalid id"], 500);

$stmt = $pdo->prepare('UPDATE `recipes` SET `is_pending` = 0, `is_denied` = 0 WHERE `recipe_id` = ?');
$stmt->execute([$id]);

send_response([
    "success" => true
]);