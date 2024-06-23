const utils = new Utils();

let query = {
    category: null,
    search: "",
    myFridge: false
}

fetchRecipes().then();

document.getElementById('recipe-search').addEventListener('input', utils.debounce((e) => {
    query = { ...query, search: e.target.value };
    fetchRecipes().then();
}))

document.getElementById('myfridge-check').addEventListener('change', e => {
    query = { ...query, myFridge: e.target.checked };
    fetchRecipes().then();
})

function handleClick(target) {
    const elements = document.querySelectorAll('.recipe-category');

    elements.forEach(element => {
        element.classList.remove('btn-primary');
        element.classList.add('btn-secondary');
    })

    const categoryId = target.getAttribute('data-categoryid');

    if (categoryId === query.category) {
        query = { ...query, category: null };
        fetchRecipes().then();

        return;
    }

    target.classList.remove('btn-secondary');
    target.classList.add('btn-primary');

    console.log('search', categoryId)
    query = { ...query, category: categoryId }
    fetchRecipes().then();
}

window.addEventListener('load', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
})

const handleRecipeClick = (id) => window.location.href = `./recipe?id=${id}`;

async function fetchRecipes() {
    const recipesContainer = document.getElementById("recipes-container");

    recipesContainer.style.justifyContent = 'center';
    utils.createSpinner(recipesContainer, true);

    const resp = await fetch('api/get-recipes', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ...query })
    })

    const data = await resp.json();

    utils.cancelSpinner(recipesContainer, "");
    recipesContainer.style.justifyContent = 'flex-start';

    const { recipes } = data;

    recipes.forEach(recipe => {
        let missingEl = "";

        if (recipe.missing) {
            const ingredients = recipe.missing.join(', ')

            missingEl = `
                <p>Missing: ${ingredients}</p>
            `
        }

        recipesContainer.insertAdjacentHTML('beforeend', `
            <div class="col-sm-6 col-md-4 align-items-stretch recipe-card" onclick="handleRecipeClick(${recipe.recipe_id});" style="margin-bottom: 24px">
                <div class="card border shadow-sm h-100">
                    <div style="overflow: hidden; height: 285px;">
                        <img src="${recipe.image}" class="card-img-top" style="width: 100%; height: 285px; object-fit: cover;" alt="...">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between gap-3">
                        <div>
                            <h5 class="card-title">${recipe.title}</h5>
                            <div class="d-flex gap-3 flex-wrap-wrap">
                            </div>
                        </div>
                        
                        ${missingEl}

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span>
                                <i class="ti ti-clock text-primary"></i> ${recipe.estimate_time} min.
                            </span>
                            <span class="badge text-bg-primary">${recipe.category}</span>
                        </div>
                    </div>
                </div>
            </div>
        `)
    })

}