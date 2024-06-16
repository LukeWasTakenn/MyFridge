<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$data = get_request_data();

$id = $data['id'];
$newValue = $data['newValue'];

$stmt = $pdo->prepare('SELECT 1 FROM `categories` WHERE `value` = ?');
$stmt->execute([strtolower($newValue)]);
$result = $stmt->fetchColumn(0);

if ($result) send_response([
    "error" => "This category already exists"
]);

$stmt = $pdo->prepare('UPDATE `categories` SET `label` = ?, `value` = ? WHERE `category_id` = ?');

$success = $stmt->execute([$newValue, strtolower($newValue), $id]);

if (!$success) send_response(["error" => "Something went wrong"], 500);

send_response([
    "success" => true
]);