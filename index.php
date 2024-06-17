<?php

const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;

require BASE_PATH . 'functions.php';
require base_path("config.php");
require base_path("db_config.php");

spl_autoload_register(function (string $class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require_once base_path("classes" . DIRECTORY_SEPARATOR . "{$class}.php");
});


$router = new Router();

// page routes
$router->get('/', 'landing');
$router->get('/login', 'login');
$router->get('/sign-up', 'sign-up');
$router->get('/recipes', 'recipes');
$router->get('/verify', 'verify');
$router->get('/new-recipe', 'new-recipe');
$router->get('/admin', 'admin/index');

// API routes
$router->post("/api/register-user", "register-user");
$router->post("/api/login-user", "login-user");
$router->post("/api/logout", "logout");

$router->post("/api/categories/create", "categories/create");
$router->post("/api/categories/remove", "categories/remove");
$router->post("/api/categories/edit", "categories/edit");
$router->post("/api/categories/get", "categories/get");

$router->post("/api/ingredients/get", "ingredients/get");
$router->post("/api/ingredients/create", "ingredients/create");
$router->post("/api/ingredients/remove", "ingredients/remove");
$router->post("/api/ingredients/edit", "ingredients/edit");

$router->post("/api/accounts/ban", "accounts/ban");
$router->post("/api/accounts/unban", "accounts/unban");


$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($url, $method);