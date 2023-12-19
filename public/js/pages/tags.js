import {encodeForAjax, sendAjaxRequest} from "../app.js";
import {projectTagsPageRegex} from "../const/regex.js";

const currentPath = window.location.pathname;
const edits_actions = document.querySelectorAll('.tagCard .edit');
const edits_submits = document.querySelectorAll(".tagSection form");
const deletes = document.querySelectorAll('.tagCard .delete');

edits_actions.forEach(
    (edit) => edit.addEventListener('click',
        (e)=>{

            const tag_id = edit.parentNode.parentNode.id.match(/tagCard-(\d+)/)[1];
            const form = document.querySelector('#edit-' + tag_id);
            form.classList.toggle('hidden');

        }
) );

edits_submits.forEach(
    (edit) => edit.addEventListener('submit',
        async (e) => {
                e.preventDefault();
                const project_id = currentPath.match(projectTagsPageRegex)[1];
                const tag_id = edit.id.match(/edit-(\d+)/)[1];
                const title = document.querySelector('#edit-'+tag_id+" input[type='text'");
                const project_response = await sendAjaxRequest("PUT", "/project/"+project_id+"/tag/"+tag_id +"/edit",{'title':title.value});
                const res = await project_response.json();
                const errors = document.querySelector('#edit-'+tag_id +' .error')
                console.log(res);
                if(res.errors){
                    errors.innerHTML=res.errors;
                    return;
                }
                errors.innerHTML='';
                document.querySelector('#tagCard-'+tag_id+' .tagContainer .tag').innerText=title.value;
                const form = document.querySelector('#edit-' + tag_id);
                form.classList.toggle('hidden');

        }
    )
)