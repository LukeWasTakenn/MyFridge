<?php

require base_path('includes/header.php');
?>

<main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px;">
        <div>
            <h2 class="mb-0">Sign up</h2>
            <p class="text-secondary fs-7 m-0">Create an account</p>
        </div>
        <form class="d-flex flex-column gap-3">
            <div class="d-flex gap-2">
                <div>
                    <label for="firstname">First name</label>
                    <input id="firstname" class="form-control"/>
                </div>
                <div>
                    <label for="lastname">Last name</label>
                    <input id="lastname" class="form-control"/>
                </div>
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control"/>
            </div>
            <div>
                <label for="phone-number">Phone number</label>
                <input id="phone-number" class="form-control"/>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control"/>
            </div>
            <div>
                <label for="confirm-password">Confirm password</label>
                <input id="confirm-password" type="password" class="form-control"/>
            </div>
            <button class="btn btn-primary">
                Sign up
            </button>
        </form>
        <div class="fs-7 text-align-center">Already have an account? <a class="primary-link" href="<?=BASE_URL?>/login"
            >
                Log in
            </a>
        </div>
    </div>
</main>

<?php

require base_path('includes/footer.php');
