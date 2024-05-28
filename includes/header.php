<?php
session_start();

$url = basename($_SERVER['REQUEST_URI'], '.php');
$url = explode('.php', $url);

$page = $url[0];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MyFridge</title>

    <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
    ></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/assets/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/assets/css/bootstrap.override.css"/>


    <?php
        if (!empty($HEADER_LINKS)) {
            foreach ($HEADER_LINKS as $link)
                echo $link;
        }
    ?>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid container-md">
        <a class="navbar-brand" href="<?=BASE_URL?>/">MyFridge</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'recipes' ? 'active' : null ?>" aria-current="page" href="<?=BASE_URL?>/recipes">Recipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'bookmarks' ? 'active' : null ?>" href="#">Bookmarks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'my_fridge' ? 'active' : null ?>" href="#">My Fridge</a>
                </li>
            </ul>
            <div class="navbar-nav">
                <?php

                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    echo "<p>{$user->first_name} {$user->last_name}</p>";
                } else {
                    echo "<a class=\"p-0 m-0 nav-link <?= $page === 'login' ? 'active' : null ?>\" href=\"" . BASE_URL . "/login\">Login</a>";
                }

                ?>
            </div>
        </div>
    </div>
</nav>