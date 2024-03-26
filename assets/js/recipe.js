function handleClick(target) {
    const elements = document.querySelectorAll('.recipe-category');

    elements.forEach(element => {
        element.classList.remove('btn-primary');
        element.classList.add('btn-secondary');
    })

    target.classList.remove('btn-secondary');
    target.classList.add('btn-primary');
}

window.addEventListener('load', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
})

