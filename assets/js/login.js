"use strict"

const utils = new Utils();

const form = document.getElementById("login-form");

let shouldSubmit = true;

function setError(target, message) {
    const element = document.getElementById(target);
    element.innerHTML = message;
    shouldSubmit = false;
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);

    utils.resetErrors(fields);

    fields.forEach(field => {
        if (!values[field]) setError(`${field}-error`, "Field required.");
    })

    if (!shouldSubmit) return;

    const submitBtn = document.getElementById("login-form-submit");

    utils.createSpinner(submitBtn);

    const resp = await fetch("api/login-user", {
        method: 'POST',
        body: JSON.stringify(values),
        headers: {
            'Content-Type': 'application/json'
        }
    })

    const data = await resp.json();

    utils.cancelSpinner(submitBtn, "Login");

    if (!data.error) {
        // TODO: figure out redirect
        return;
    }

    switch (data.error) {
        case 'unverified':
            setError("email-error", "This account has not verified yet.");
            break;
        case 'banned':
            setError("email-error", "This account has been banned.");
            break;
        case "account_not_exists":
            setError("email-error", "This account does not exist.");
            break;
        case 'incorrect_password':
            setError("password-error", "Incorrect password.");
            break;
    }

})