<?php

declare(strict_types=1);
session_start();

$user = $_SESSION['user'];

if (!isset($user)) {
    send_response([
        "success" => false
    ], 401);
}

$_SESSION['user'] = null;
session_destroy();

send_response([
    "success" => true
]);