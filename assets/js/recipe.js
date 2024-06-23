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

async function handleBookmark() {
    const btn = document.getElementById('bookmark-btn');

    btn.innerHTML = `
        <i class="ti ti-check"></i>
        Bookmarked
    `

    btn.onclick = handleUnBookmark;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    await fetch('api/bookmark/create', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    }).then()
}

async function handleUnBookmark() {
    const btn = document.getElementById('bookmark-btn');

    btn.innerHTML = `
        <i class="ti ti-bookmark"></i>
        Bookmark
    `

    btn.onclick = handleBookmark;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    await fetch('api/bookmark/delete', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    }).then()
}