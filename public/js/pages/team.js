import { attachDialogs } from "../modal.js";
import { sendAjaxRequest } from "../app.js";

const currentPath = window.location.pathname;

document.addEventListener('DOMContentLoaded', function () {
    attachDialogs();
    addRemoveUserEvent();
    giveUserToActionHandler();
});

function giveUserToActionHandler() {
    const actionBtn = document.querySelector('#removeUserBtn');

    document.querySelectorAll('.remove-user-btn').forEach((button) => {
        button.addEventListener('click', () => {
            actionBtn.dataset.user = button.dataset.user;
        })
    })
}

function addRemoveUserEvent() {
    const actionBtn = document.querySelector('#removeUserBtn');

    actionBtn.addEventListener('click', () => {
        sendAjaxRequest('DELETE', currentPath + '/remove', {'user': actionBtn.dataset.user}).catch(() => {
            console.error("Network error");
        }).then(async response => {
            const data = await response.json();

            if (response.ok) {
                document.querySelector('#user-item-' + actionBtn.dataset.user).remove();
                document.querySelectorAll('dialog').forEach(dialog => {
                    dialog.close();
                });
            }
            else {
                console.error(`Error ${response.status}: ${data.error}`);
            }
        }).catch(() => {
            console.error('Error parsing JSON');
        })
    });
}