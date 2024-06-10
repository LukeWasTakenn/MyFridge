<div class="d-flex flex-column admin-nav-card shadow-sm">
    <a href="<?=BASE_URL?>/admin" class="admin-nav-item <?=$file === 'dashboard.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-layout-dashboard"></i>
        <p>Dashboard</p>
    </a>
    <a href="<?=BASE_URL?>/admin?page=recipes" class="admin-nav-item <?=$file === 'recipes.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-book"></i>
        Recipes
    </a>
    <a href="<?=BASE_URL?>/admin?page=recipe_requests" class="admin-nav-item <?=$file === 'recipe-requests.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-send"></i>
        Recipe requests
    </a>
    <a href="<?=BASE_URL?>/admin?page=categories" class="admin-nav-item <?=$file === 'categories.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-category"></i>
        Categories
    </a>
    <a href="<?=BASE_URL?>/admin?page=ingredients" class="admin-nav-item <?=$file === 'ingredients.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-lemon-2"></i>
        Ingredients
    </a>
    <a href="<?=BASE_URL?>/admin?page=accounts" class="admin-nav-item <?=$file === 'accounts.php' ? 'admin-nav-item-active' : null?>">
        <i class="ti ti-users"></i>
        Accounts
    </a>
</div>