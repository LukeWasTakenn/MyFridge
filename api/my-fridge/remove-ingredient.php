<?php

declare(strict_types=1);
session_start();

global $pdo;

$user = $_SESSION['user'] ?? '';

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();
$id = $data['id'] ?? '';

if (!$id) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('DELETE FROM `fridge_ingredients` WHERE `account_id` = ? AND `ingredient_id` = ?');
$success = $stmt->execute([$user->id, $id]);

if (!$success) send_response(["error" => "Something went wrong"], 500);

send_response([
    "success" => true
]);
