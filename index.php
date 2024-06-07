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

// API routes
$router->post("/api/register-user", "register-user");
$router->post("/api/login-user", "login-user");

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($url, $method);