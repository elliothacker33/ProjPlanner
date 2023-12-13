import { sendAjaxRequest } from './app.js'
import { attachModal, addOpenModalBtn } from './modal.js'
import { config_multiselector, multiselector } from "./multiselector.js";
import { getDateString } from './utils.js';

const currentPath = window.location.pathname;

function addTaskEventHandlers() {
    const closeTaskButton = document.querySelector('#closeTaskBtn');
    const cancelTaskButton = document.querySelector('#cancelTaskBtn');
    const reopenTaskButton = document.querySelector('#reopenTaskBtn');
    const form = document.querySelector('form');

    if (closeTaskButton != null) changeTaskStatusEvent(closeTaskButton, 'closed');
    if (cancelTaskButton != null) changeTaskStatusEvent(cancelTaskButton, 'canceled');
    if (reopenTaskButton != null) changeTaskStatusEvent(reopenTaskButton, 'open');

    document.querySelectorAll('dialog').forEach((dialog) => {
        attachModal(dialog);
        const openBtn = document.querySelector('#' + dialog.dataset.openFormId);

        if (openBtn != null) addOpenModalBtn(dialog);
    })

    config_multiselector();

    if (form != null) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            multiselector('.users', '#assigns');
            multiselector('.tags', '#tags');
            form.submit();
        });
    }    
};

function changeTaskStatusEvent(button, status) {
    button.addEventListener('click', () =>{
        sendAjaxRequest('PUT', currentPath + '/edit/status', {'status': status}).catch(() => {
            console.error("Network error");
        }).then(async response => {
            const data = await response.json();

            if (response.ok) {
                const statusChip = document.querySelector('.status');
                const deadline = document.querySelector('.deadlineContainer')
                const finishedTimeSpan = document.createElement('span');
                const actionString = status.charAt(0).toUpperCase() + status.slice(1);
                
                buildStatusButtons(data.status);

                statusChip.classList.remove('open');
                statusChip.classList.remove('closed');
                statusChip.classList.remove('canceled');
                statusChip.classList.add(status);
                statusChip.innerHTML = actionString;

                deadline.innerHTML = '';

                finishedTimeSpan.innerHTML = (data.status == 'open' ? 'Deadline: ': `${actionString} at: `) + getDateString((data.status == 'open' ? data.deadline : data.endtime));
                deadline.appendChild(finishedTimeSpan);

                document.querySelectorAll('dialog').forEach(dialog => {
                    dialog.close();
                });
            }
            else {
                console.error(`Error ${response.status}: ${data.error}`);
            }
        })/*.catch(() => {
            console.error('Error parsing JSON');
        })*/
    });
};

function buildStatusButtons(status) {
    const closeOpenContainer = document.querySelector('.primaryContainer');
    const editCancelContainer = document.querySelector('.actions');

    if (status == 'open') {
        document.querySelector('#openReopenModal').remove();

        const closeTaskBtn = document.createElement('a');
        const cancelTaskBtn = document.createElement('a');
        const editTaskBtn = document.createElement('a');

        closeTaskBtn.classList.add('buttonLink');
        closeTaskBtn.setAttribute('id', 'openCloseModal');
        closeTaskBtn.innerHTML = 'Close task';

        cancelTaskBtn.classList.add('buttonLink');
        cancelTaskBtn.classList.add('cancel');
        cancelTaskBtn.setAttribute('id', 'openCancelModal');
        cancelTaskBtn.innerHTML = 'Cancel';

        editTaskBtn.classList.add('buttonLink');
        editTaskBtn.classList.add('edit');
        editTaskBtn.innerHTML = 'Edit';

        closeOpenContainer.appendChild(closeTaskBtn);
        editCancelContainer.appendChild(editTaskBtn);
        editCancelContainer.appendChild(cancelTaskBtn);
    }
    else {
        document.querySelector('#openCloseModal').remove();
        document.querySelector('#openCancelModal').remove();
        editCancelContainer.querySelector('.edit').remove();

        const reopenTaskBtn = document.createElement('a');
        reopenTaskBtn.classList.add('buttonLink');
        reopenTaskBtn.setAttribute('id', 'openReopenModal');
        reopenTaskBtn.innerHTML = 'Reopen task';

        closeOpenContainer.appendChild(reopenTaskBtn);
    }

    document.querySelectorAll('dialog').forEach((dialog) => {
        const openBtn = document.querySelector('#' + dialog.dataset.openFormId);

        if (openBtn != null) addOpenModalBtn(dialog);
    })
}

addTaskEventHandlers();
