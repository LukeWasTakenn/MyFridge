class Utils {
    createSpinner(element) {
        element.innerHTML = `
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        `

        element.disabled = true;
    }
}