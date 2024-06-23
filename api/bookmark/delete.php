<?php

session_start();

global $pdo;

$user = $_SESSION['user'] ?? '';

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$id = $data['id'] ?? "";

if (!$id) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('DELETE FROM `recipe_bookmarks` WHERE `recipe_id` = ? AND `account_id` = ?');
$stmt->execute([$id, $user->id]);

send_response([
    "success" => true
]);