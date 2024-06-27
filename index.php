<?php

const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;

require BASE_PATH . 'functions.php';
require base_path("config.php");
require base_path("db_config.php");
require base_path('vendor/autoload.php');


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
$router->get('/edit-recipe', 'edit-recipe');
$router->get('/forgot-password', 'forgot-password');
$router->get('/reset', 'reset');
$router->get('/recipe', 'recipe');
$router->get('/admin', 'admin/index');
$router->get('/settings', 'account/settings');
$router->get('/my-fridge', 'account/my-fridge');
$router->get('/my-recipes', 'account/my-recipes'); //
$router->get('/bookmarks', 'account/bookmarks'); //

// API routes
$router->post("/api/register-user", "register-user");
$router->post("/api/login-user", "login-user");
$router->post("/api/logout", "logout");
$router->post("/api/forgot-password", "forgot-password");
$router->post("/api/reset", "reset");

$router->post("/api/settings/update-profile", "settings/update-profile");
$router->post("/api/settings/update-password", "settings/update-password");

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
$router->post("/api/accounts/get", "accounts/get");

$router->post("/api/recipe/create", "recipe/create");
$router->post("/api/recipe/delete", "recipe/delete");
$router->post("/api/recipe/get", "recipe/get");
$router->post("/api/recipe/edit", "recipe/edit");
$router->post("/api/recipe/get-description", "recipe/get-description");
$router->post("/api/recipe/approve-recipe", "recipe/approve-recipe");
$router->post("/api/recipe/deny-recipe", "recipe/deny-recipe");

$router->post("/api/my-fridge/get-ingredients", "my-fridge/get-ingredients");
$router->post("/api/my-fridge/insert-ingredient", "my-fridge/insert-ingredient");
$router->post("/api/my-fridge/remove-ingredient", "my-fridge/remove-ingredient");

$router->post("/api/get-recipes", "get-recipes");

$router->post("/api/bookmark/create", "bookmark/create");
$router->post("/api/bookmark/delete", "bookmark/delete");



$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($url, $method);