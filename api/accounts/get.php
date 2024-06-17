<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$search = $data['search'] ?? "";
$isBannedAccounts = $data['isBannedAccounts'];

$searchStr = "%{$search}%";

$stmt = $pdo->prepare('SELECT `account_id`, `first_name`, `last_name`, `email`, `phone_number`, `role` FROM `accounts` WHERE (`first_name` LIKE ? OR `last_name` LIKE ? OR `email` LIKE ? OR  `phone_number` LIKE ? OR `role` LIKE ?) AND `is_banned` = ?');
$stmt->execute([$searchStr, $searchStr, $searchStr, $searchStr, $searchStr, $isBannedAccounts ? 1 : 0]);

$accounts = $stmt->fetchAll(PDO::FETCH_OBJ);

send_response([
    "accounts" => $accounts
]);
