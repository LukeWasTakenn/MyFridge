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

    utils.cancelSpinner(button, "Update profile");

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

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
})