import { sendAjaxRequest } from "./app";

const currentPath = window.location.pathname;

console.log(currentPath);

document.querySelectorAll('.own-post').forEach((post) => {

    post.querySelector('.edit-post').addEventListener('click', async (e) => {
        e.preventDefault();

        const id = post.id;

        const post_body = post.querySelector('.post-body');
        const text = post.querySelector('.content').innerHTML;

        const textarea = document.createElement('textarea');
        const submit = document.createElement('a');
        const cancel = document.createElement('button');

        textarea.classList.add('editPostTextarea');
        submit.classList.add('edit-post');
        cancel.classList.add('edit-post');

        textarea.value = text;
        
        submit.href = '/forum/'+id+'/edit';
        submit.innerHTML = 'Save';
        cancel.innerHTML = 'Cancel';

        post_body.innerHTML = '';
        post_body.appendChild(textarea);
        post_body.appendChild(submit);
        post_body.appendChild(cancel);

        const p = document.createElement('p');
        p.classList.add('content');

        submit.addEventListener('click', async (e) => {
            e.preventDefault();

            const content = textarea.value;

            console.log(currentPath+'/'+id+'/edit');

            const response = await sendAjaxRequest('PUT', currentPath+'/'+id+'/edit', {'content': content});

            const data = await response.json();

            if (data.status === 'success') {
                p.innerHTML = content;

                p.innerHTML = content;
                post_body.appendChild(p);
            }
        });

        cancel.addEventListener('click', async (e) => {
            e.preventDefault();

            post_body.innerHTML = '';

            p.innerHTML = text;
            post_body.appendChild(p);
        });
    });
});
