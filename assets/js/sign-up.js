"use strict";

const utils = new Utils();

let shouldSubmit = true;

const form = document.getElementById("sign-up-form");

const isValidEmail = (email) => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email);
const isValidPhoneNumber = (phoneNumber) => /^[0-9]*$/.test(phoneNumber)

function setError(target, message) {
    const element = document.getElementById(target);
    element.innerHTML = message;
    shouldSubmit = false
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());

    const fields = Object.keys(values);
    utils.resetErrors(fields);

    values.firstName = "dsadas";
    values.lastName = "dasdas";
    values.email = "dsaodksoa@gmail.com";
    values.phoneNumber = "321321123";
    values.password = "password";
    values.confirmPassword = "password";

    fields.forEach(field => {
        if (!values[field]) setError(`${field}-error`, "Field required.");
    })

    if (!isValidEmail(values.email)) setError("email-error", "Invalid email format.")
    if (values.password.length < 8) setError("password-error", "Password must be at least 8 characters long.")
    if (values.password !== values.confirmPassword) setError("confirmPassword-error", "Passwords do not match.")
    if (!isValidPhoneNumber(values.phoneNumber)) setError("phoneNumber-error", "Invalid phone number format.")

    if (!shouldSubmit) return;

    const submitButton = document.getElementById("sign-up-submit")

    utils.createSpinner(submitButton);

    const resp = await fetch("api/register-user", {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(values)
    })

    const data = await resp.json();

    if (resp.status !== 200) {
        if (data.field)
            setError(`${data.field}-error`, data.error)
        else
            setError("form-error", data.error)
        console.log(data);
        return;
    }

    form.outerHTML = "<p>Account successfully created. Please verify your email.</p>";
    document.getElementById("existing-account").remove();

})