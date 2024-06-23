<?php

declare(strict_types=1);
session_start();

global $pdo;

$user = $_SESSION['user'] ?? "";

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$id = $data['id'] ?? '';

if (!$id) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('SELECT `creator_id` FROM `recipes` WHERE `recipe_id` = ?');
$stmt->execute([$id]);

$creatorId = $stmt->fetchColumn(0);

if (!isAdmin() && $creatorId !== $user->id) send_response(["error" => "unauthorized"], 401);

$stmt = $pdo->prepare('UPDATE `recipes` SET `is_denied` = 1 WHERE `recipe_id` = ?');
$stmt->execute([$id]);

send_response(["success" => true]);