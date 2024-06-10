<?php

require base_path('includes/header.php');

?>

    <main class="container-fluid container-md min-vh-100 d-flex justify-content-start justify-content-md-between align-items-center flex-column flex-lg-row gap-5">
        <div class="d-flex align-items-start flex-column gap-4" style="flex: 0.5">
            <h1 class="m-0">Find recipes from <span style="color:hsl(var(--primary));">your</span> fridge</h1>
            <p class="text-secondary">Stretch your grocery budget with MyFridge. Amazing meals made easy.</p>
            <a class="btn btn-primary" href="<?=BASE_URL?>/recipes">
                Browse recipes ->
            </a>
        </div>
        <div class="d-flex flex-column flex-lg-row gap-2" style="flex: 0.5">
            <div>
                <img src="<?=BASE_URL?>/assets/images/hero-1.jpg" class="rounded img-fluid"/>
            </div>
            <div>
                <img src="<?=BASE_URL?>/assets/images/hero-2.jpg" class="rounded img-fluid">
            </div>
            <div>
                <img src="<?=BASE_URL?>/assets/images/hero-3.jpg" class="rounded img-fluid"/>
            </div>
        </div>
    </main>


<?php

require base_path('includes/footer.php');