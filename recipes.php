<?php

include_once 'includes/header.php';

?>

<main class="container-fluid container-md min-vh-100 pt-4">
    <div class="d-flex flex-1 flex-column flex-lg-row gap-5">
        <div class="shadow-sm d-flex gap-2 flex-column border p-4 rounded" style="height: fit-content; flex: 0.3;">
            <h4>Filters</h4>
            <input class="form-control" placeholder="Search..."/>
            <p class="m-0">Categories</p>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Breakfast
                </button>
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Lunch
                </button>
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Dinner
                </button>
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Desert
                </button>
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Appetiser
                </button>
                <button class="btn btn-sm" style="background-color: var(--secondary-100)">
                    Soup
                </button>
            </div>
        </div>
            <div class="row" style="flex: 0.7">
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                    <div class="card border shadow-sm">
                        <div style="overflow: hidden; ">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1980&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Canadian style pancakes</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<?php

include_once 'includes/footer.php';
