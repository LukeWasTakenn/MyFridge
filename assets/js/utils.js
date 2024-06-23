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

    createAutocomplete(inputElementId, autocompleteElementId, dataset) {
        const input = document.getElementById(inputElementId);
        const autocomplete = document.getElementById(autocompleteElementId);

        autocomplete.style.visibility = 'hidden';

        autocomplete.addEventListener('click', e => {
            if (!e.target.classList.value.includes('autocomplete-item')) return;

            input.value = e.target.innerText;
            autocomplete.style.visibility = 'visible';
        })

        input.addEventListener('input', (e) => {
            if (e.target.value.length <= 1) {
                autocomplete.style.visibility = 'hidden';
                return;
            }

            const inputValue = e.target.value.toLowerCase();

            const suggestions = dataset.filter(value => value.toLowerCase().includes(inputValue) && value.toLowerCase() !== inputValue);

            autocomplete.innerHTML = "";

            if (suggestions.length < 1) {
                autocomplete.style.visibility = 'hidden';
                return;
            }

            suggestions.forEach(suggestion => {
                autocomplete.insertAdjacentHTML('beforeend', `
                    <button type="button" class="btn autocomplete-item">${suggestion}</button>
                `)
            })

            autocomplete.style.visibility = 'visible';

        })
    }

    firstToUpper(str) {
        return str[0].toUpperCase() + str.slice(1);
    }
}