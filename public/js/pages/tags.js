import {edit_tag,delete_tag} from "../api/tag.js";

const edits_actions = document.querySelectorAll('.tagCard .edit');
const edits_submits = document.querySelectorAll(".tagSection form");
const deletes = document.querySelectorAll('.tagCard .delete');
deletes.forEach(
    (delete_action ) => delete_action.addEventListener('click',
        (e)=>{
                // call modal

        })
)

edits_actions.forEach(
    (edit) => edit.addEventListener('click',
        (e)=>{
            const tag_id = edit.parentNode.parentNode.parentNode.id.match(/tag(\d+)/)[1];
            const form = document.querySelector('#tag' + tag_id+' form');
            form.classList.toggle('hidden');
        }
) );
edits_submits.forEach(
    (edit) => edit.addEventListener('submit',
        async (e) => {
                e.preventDefault();
                const tag_id = edit.parentNode.id.match(/tag(\d+)/)[1];
                const title = document.querySelector('#tag'+tag_id+" form input[type='text'");
                const errors = document.querySelector('#tag'+tag_id +' .error')
                try{
                    await edit_tag(tag_id,title);
                }catch (err){
                    errors.innerHTML=err;
                    return;
                }
                errors.innerHTML='';
                document.querySelector('#tag'+tag_id+' .tagCard .tagContainer .tag').innerText=title.value;
                const form = document.querySelector('#tag' + tag_id+' form');
                form.classList.toggle('hidden');
        }
    )
);
