import {sendAjaxRequest} from './app.js'
import {attachModal} from './modal.js'

const currentPath = window.location.pathname;

function addTaskEventHandlers() {
    const closeTaskButton = document.querySelector('#closeTaskBtn');
    const cancelTaskButton = document.querySelector('#cancelTaskBtn');

    if (closeTaskButton != null) closeAndCancelEvent(closeTaskButton, '/close', 'Closed');
    if (cancelTaskButton != null) closeAndCancelEvent(cancelTaskButton, '/cancel', 'Canceled');

    document.querySelectorAll('dialog').forEach((dialog) => {
        attachModal(dialog);
    })
};

function closeAndCancelEvent(button, route, actionString) {
    button.addEventListener('click', (e) => {
        const userid = button.dataset.userid;

        sendAjaxRequest('PUT', currentPath + route, {'closed_user_id': userid}).catch(() => {
            console.error("Network error");
        }).then(response => {
            if (response.ok) {
                const statusChip = document.querySelector('.status');
                const deadline = document.querySelector('.deadlineContainer')
                const finishedTimeSpan = document.createElement('span');

                document.querySelectorAll('.actions a').forEach(element => {
                    element.remove();
                })
                document.querySelector('#closeTaskBtn').remove();

                statusChip.classList.remove('open');
                statusChip.classList.add(actionString.toLowerCase());
                statusChip.innerHTML = actionString;

                deadline.innerHTML = '';

                const today = new Date();
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();

                finishedTimeSpan.innerHTML = `${actionString} at: ${day}-${month}-${year}`;
                deadline.appendChild(finishedTimeSpan);
            }
        })
    });
};

addTaskEventHandlers();
