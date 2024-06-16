<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$data = get_request_data();

$id = $data['id'];

$stmt = $pdo->prepare('DELETE FROM `ingredients` WHERE `ingredient_id` = ?');

$success = $stmt->execute([$id]);

if (!$success) {
    send_response([
        "error" => "Something went wrong"
    ], 500);
}

send_response([
    "success" => true
]);

