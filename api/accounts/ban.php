<?php
declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$targetAccountId = $data['accountId'];

$stmt = $pdo->prepare('SELECT 1 FROM `accounts` WHERE `account_id` = ? AND role = ?');
$stmt->execute([$targetAccountId, 'role']);

if ($stmt->fetchColumn(0)) send_response(["error" => "unauthorized"], 401);

$stmt = $pdo->prepare('UPDATE `accounts` SET `is_banned` = 1 WHERE `account_id` = ?');
$success = $stmt->execute([$targetAccountId]);

send_response([
    "success" => $success
], $success ? 200 : 500);
