<?php
session_start();

$url = basename($_SERVER['REQUEST_URI'], '.php');
$url = explode('.php', $url);

$page = $url[0];

$user = $_SESSION['user'] ?? null;


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
        <button  class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Navigation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link <?= $page === 'recipes' ? 'active' : null ?>" aria-current="page" href="<?=BASE_URL?>/recipes">Recipes</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <?php if ($user) :?>
                        <div class="dropdown d-lg-flex d-xs-none">
                            <button data-bs-toggle="dropdown" class="user-avatar rounded-circle p-2 d-none d-lg-flex">
                                <i class="ti ti-user"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if ($user->role === 'admin') :?>
                                <li><a class="dropdown-item" href="<?=BASE_URL?>/admin"><i class="ti ti-shield"></i> Admin</a></li>
                                <?php endif?>
                                <li><a class="dropdown-item" href="<?=BASE_URL?>/my-fridge"><i class="ti ti-fridge"></i> My Fridge</a></li>
                                <li><a class="dropdown-item" href="<?=BASE_URL?>/my-recipes"><i class="ti ti-book"></i> My Recipes</a></li>
                                <li><a class="dropdown-item" href="<?=BASE_URL?>/bookmarks"><i class="ti ti-bookmark"></i> Bookmarks</a></li>
                                <li><a class="dropdown-item" href="<?=BASE_URL?>/settings"><i class="ti ti-settings"></i> Settings</a></li>
                                <li onclick="handleLogout();"><a class="dropdown-item" href="#"><i class="ti ti-logout"></i> Log out</a></li>
                            </ul>
                        </div>

                        <!-- Mobile navigation -->
                        <h5 class="d-lg-none mt-4">Account</h5>
                        <?php if ($user->role === 'admin') :?>
                            <li class="nav-item d-lg-none"><a class="nav-link" href="<?=BASE_URL?>/admin"><i class="ti ti-shield"></i> Admin</a></li>
                        <?php endif?>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="<?=BASE_URL?>/my-fridge"><i class="ti ti-fridge"></i> My Fridge</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="<?=BASE_URL?>/my-recipes"><i class="ti ti-book"></i> My Recipes</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="<?=BASE_URL?>/bookmarks"><i class="ti ti-bookmark"></i> Bookmarks</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="<?=BASE_URL?>/settings"><i class="ti ti-settings"></i> Settings</a></li>
                        <li onclick="handleLogout();" class="nav-item d-lg-none"><a class="nav-link" href="#"><i class="ti ti-logout"></i> Log out</a></li>
                    <?php else :?>
                        <a class="nav-link <?= $page === 'login' ? 'active' : null ?>" aria-current="page" href="<?=BASE_URL?>/login">Login</a>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=BASE_URL?>/assets/js/header.js"></script>
</nav>