<?php

declare(strict_types=1);

$pdo = new PDO("mysql:host=" . DB["host"] . ";dbname=" . DB["name"], DB["username"], DB["password"]);

if ($pdo->errorCode()) dd($pdo->errorCode());
