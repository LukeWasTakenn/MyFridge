<?php

include_once 'includes/header.php';

?>

    <main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex gap-3 flex-column rounded p-3 shadow border login-container w-100">
            <div>
                <h2 class="mb-0">Login</h2>
                <p class="text-secondary fs-7 m-0">Start exploring your favourite recipes today</p>
            </div>
            <form class="d-flex flex-column gap-3">
                <div>
                    <label for="email">Email</label>
                    <input id="email" class="form-control"/>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" class="form-control"/>
                </div>
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover primary-link fs-7"
                   href="#"
                >
                    Forgot password?
                </a>
                <button class="btn btn-primary">
                    Login
                </button>
            </form>
            <div class="fs-7">Don't have an account? <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover primary-link"
                >
                    Sign up
                </a>
            </div>
        </div>
    </main>

<?php

include_once 'includes/footer.php';