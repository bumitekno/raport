// Basic

// var quill = new Quill('#editor-container', {
//     modules: {
//         toolbar: [
//             [{ header: [1, 2, false] }],
//             ['bold', 'italic', 'underline'],
//             ['image', 'code-block']
//         ]
//     },
//     placeholder: 'Compose an epic...',
//     theme: 'snow'  // or 'bubble'
// });

var quill = new Quill('#content-container #editor', {
    modules: {
        toolbar: '#toolbar-container'
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'
});

// Update value of the textarea on every change in the editor
quill.on('text-change', function () {
    var contents = quill.root.innerHTML;
    $('.editor').val(contents);
});
