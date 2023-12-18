import { attachDialogs } from './modal.js'

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.project-action-button').forEach(function (action) {
      action.addEventListener('click', function () {
            let actionId = action.getAttribute("id");
            let formId = actionId.substring(0, actionId.lastIndexOf("-") + 1) + "form";
        
            let form = document.querySelector("#" + formId);
            form.submit();
        });
    })
});

attachDialogs();