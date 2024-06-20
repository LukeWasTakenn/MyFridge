const utils = new Utils();

const quill = new Quill('#editor', {
    theme: 'snow',
    bounds: document.getElementById("container"),
    readOnly: true,
    modules: {
        toolbar: null
    },
})