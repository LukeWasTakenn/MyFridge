class Utils {
    createSpinner(element, primary) {
        element.innerHTML = `
        <div class="spinner-border align-self-center ${primary ? 'text-primary' : null} ${primary ? 'spinner-border-md' : 'spinner-border-sm'}" role="status">
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

    debounce(fn, delay = 250) {
        let timer = null;
        return function () {
            let context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(context, args);
            }, delay);
        };
    }

    setError(target, message) {
        const element = document.getElementById(target);
        element.innerHTML = message;
    }
}