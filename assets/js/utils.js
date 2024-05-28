class Utils {
    createSpinner(element) {
        element.innerHTML = `
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        `

        element.disabled = true;
    }

    cancelSpinner(element, text) {
        element.innerHTML = text;
        element.disabled = false;
    }

    resetErrors(fields) {
        fields.forEach(field => {
            const fieldElement = document.getElementById(`${field}-error`);
            fieldElement.innerHTML = "";
        })
    }

}