const utils = new Utils();

const form = document.getElementById('reset-password-form');

let shouldSubmit = true;

function setError(target, message) {
    const element = document.getElementById(target);
    element.innerHTML = message;
    shouldSubmit = false;
}

form.addEventListener('submit', async e => {
    e.preventDefault();

    shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const button = document.getElementById('form-confirm');

    utils.resetErrors([
        'password',
        'confirmPassword'
    ])

    const fields = Object.keys(values);

    utils.resetErrors(fields);

    fields.forEach(field => {
        if (!values[field]) setError(`${field}-error`, "Field required.");
    })

    if (values.password !== values.confirmPassword) {
        setError(`${fields[1]}-error`, "Passwords do not match");

        shouldSubmit = false;
    }

    if (!shouldSubmit) return;

    utils.createSpinner(button);

    const params = new URLSearchParams(window.location.search);
    const token = params.get('token');

    const resp = await fetch('api/reset', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ password: values.password, confirmPassword: values.confirmPassword, token })
    })

    if (resp.status !== 200) {
        utils.createSpinner(button);

        return;
    }

    const data = await resp.json();

    if (data.error) {
        const formError = document.getElementById('form-error');
        formError.innerHTML = data.error;

        return;
    }

    form.innerHTML = 'Password successfully reset';
})