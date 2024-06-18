const utils = new Utils();

const profileForm = document.getElementById('profile-form');
const accountForm = document.getElementById('account-form');

profileForm.addEventListener('submit', async e => {
    e.preventDefault();

    let shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);

    utils.resetErrors(fields);

    fields.forEach(field => {
        if (!values[field]) {
            utils.setError(`${field}-error`, "Field required.")
            shouldSubmit = false;
        }
    })

    if (!shouldSubmit) return;

    const button = document.getElementById('profile-form-submit');

    utils.createSpinner(button);

    const resp = await fetch('api/settings/update-profile', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            firstName: values.firstName,
            lastName: values.lastName,
            phoneNumber: values.phoneNumber
        })
    })

    if (resp.status !== 200) {
        utils.cancelSpinner(button, "Update profile");
        return;
    }

    const data = await resp.json();

    utils.cancelSpinner(button, "Update profile");

    const formError = document.getElementById('profile-form-error');

    if (data.error) {
        formError.innerHTML = data.error;
        formError.classList.add('text-danger', 'error')

        return;
    }

    formError.innerHTML = "Profile successfully updated!";
    formError.style.fontSize = '14px'
    formError.classList.add('text-success');
})

accountForm.addEventListener('submit', async e => {
    e.preventDefault();

    let shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);

    utils.resetErrors(fields);

    fields.forEach(field => {
        if (!values[field]) {
            utils.setError(`${field}-error`, "Field required.")
            shouldSubmit = false;
        }
    })

    if (values.password !== values.confirmPassword) {
        utils.setError("confirmPassword-error", "Passwords do not match.");
        shouldSubmit = false
    }

    if (!shouldSubmit) return;

    const button = document.getElementById('account-form-submit');

    utils.createSpinner(button);

    const resp = await fetch('api/settings/update-password', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            currentPassword: values.currentPassword,
            password: values.password,
            confirmPassword: values.confirmPassword
        })
    })

    if (resp.status !== 200) {
        utils.cancelSpinner(button, "Update password");
        return;
    }

    const data = await resp.json();

    utils.cancelSpinner(button, "Update password");

    const formError = document.getElementById('account-form-error');

    formError.classList.remove('text-danger', 'error', 'text-success');

    if (data.error) {
        formError.innerHTML = data.error;
        formError.classList.add('text-danger', 'error');

        return;
    }

    formError.innerHTML = 'Password successfully updated!';
    formError.classList.add('text-success');
    formError.style.fontSize = '14px';

    document.getElementById("current-password").value = "";
    document.getElementById("new-password").value = "";
    document.getElementById("confirm-new-password").value = "";
})