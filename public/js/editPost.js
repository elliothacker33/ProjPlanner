

document.querySelectorAll('.own-post').forEach((post) => {
    post.addEventListener('click', async (e) => {
        e.preventDefault();

        const post_body = post.querySelector('.post-body');
        const text = post.querySelector('.content').innerHTML;

        const form = document.createElement('div');
        const textarea = document.createElement('textarea');
        const submit = document.createElement('a');
        const cancel = document.createElement('button');

        form.classList.add('editPostForm');
        textarea.classList.add('editPostTextarea');
        submit.classList.add('edit-post');
        cancel.classList.add('buttonLink');

        textarea.value = text;
        
        submit.href = '/forum/editPost';
        submit.innerHTML = 'Save';
        cancel.innerHTML = 'Cancel';

        form.appendChild(textarea);
        form.appendChild(submit);
        form.appendChild(cancel);

        post_body.innerHTML = '';
        post_body.appendChild(form);

        cancel.addEventListener('click', async (e) => {
            e.preventDefault();

            post_body.innerHTML = text;
        });
    });
});
