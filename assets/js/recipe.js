const utils = new Utils();

const quill = new Quill('#editor', {
    theme: 'snow',
    bounds: document.getElementById("container"),
    readOnly: true,
    modules: {
        toolbar: null
    },
})

fetchRecipeDescription().then();

async function fetchRecipeDescription() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    const resp = await fetch('api/recipe/get-description', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    const contents = JSON.parse(data.contents);

    console.log(id);
    quill.setContents(contents);
}