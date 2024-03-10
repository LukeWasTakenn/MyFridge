<?php

include_once 'includes/header.php';

?>

    <main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px">
            <div>
                <h2 class="mb-0">Login</h2>
                <p class="text-secondary fs-7 m-0">Start exploring your favourite recipes today</p>
            </div>
            <form class="d-flex flex-column gap-3">
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control"/>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control"/>
                </div>
                <a class="primary-link fs-7 text-align-right"
                   href="#"
                >
                    Forgot password?
                </a>
                <button class="btn btn-primary">
                    Login
                </button>
            </form>
            <div class="fs-7 text-align-center">Don't have an account? <a class="primary-link" href="sign-up.php"
                >
                    Sign up
                </a>
            </div>
        </div>
    </main>

<?php

include_once 'includes/footer.php';