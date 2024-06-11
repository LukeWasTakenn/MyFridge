<?php

$HEADER_LINKS = [
    "<link href='" . BASE_URL .  "/assets/css/admin.css' rel='stylesheet'>",
];

require base_path('includes/header.php');

$reqPage = $_GET['page'] ?? "";

$page = match ($reqPage) {
    "recipes" => "recipes",
    "recipe_requests" => "recipe-requests",
    "categories" => "categories",
    "ingredients" => "ingredients",
    "accounts" => "accounts",
    default => "dashboard"
};


$file = $page . ".php";

?>

<main class="container-fluid container-md min-vh-100 pt-0 pt-md-4">
    <div class="d-flex flex-column flex-lg-row gap-4">
        <?php require_once base_path('includes/admin-nav.php')?>

        <div style="flex: 1">
            <?php require_once $file?>
        </div>
    </div>
</main>


<?php

require base_path('includes/footer.php');
