const utils = new Utils();

const form = document.getElementById("forgot-password-form");

form.addEventListener('submit', async e => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const emailError = document.getElementById('email-error');

    emailError.innerHTML = "";

    if (!email) {
        emailError.innerHTML = 'Email is required'

        return;
    }

    const button = document.getElementById('form-confirm');

    utils.createSpinner(button)

    const resp = await fetch('api/forgot-password', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email })
    })

    if (resp.status !== 200) {
        utils.cancelSpinner(button, 'Reset password')

        return;
    }

    const data = await resp.json();

    if (data.error) {
        emailError.innerHTML = data.error;
        utils.cancelSpinner(button, 'Reset password');

        return;
    }

    form.innerHTML = "<p>Reset password email has been sent.</p>"
})