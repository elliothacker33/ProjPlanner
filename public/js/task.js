import {sendAjaxRequest} from './app.js'

const currentPath = window.location.pathname;

function addTaskEventHandlers() {
    closeTaskButtonEvent();
    cancelTaskButtonEvent();
}

function closeTaskButtonEvent() {
    const closeTaskButton = document.querySelector('#closeTaskBtn');

    closeTaskButton.addEventListener('click', (e) => {
        const userid = closeTaskButton.dataset.userid;

        sendAjaxRequest('PUT', currentPath + '/close', {'closed_user_id': userid}).catch(() => {
            console.error("Network error");
        }).then(response => {
            if (response.ok) {
                const statusChip = document.querySelector('.status');

                document.querySelectorAll('.actions a').forEach(element => {
                    element.remove();
                })
                closeTaskButton.remove();
                statusChip.classList.remove('open');
                statusChip.classList.add('closed');
                statusChip.innerHTML = 'Closed';
            }
        })
    });
};

function cancelTaskButtonEvent() {
    const cancelTaskButton = document.querySelector('#cancelTaskBtn');

    cancelTaskButton.addEventListener('click', (e) => {
        const userid = cancelTaskButton.dataset.userid;

        sendAjaxRequest('PUT', currentPath + '/cancel', {'canceled_user_id': userid}).catch(() => {
            console.error("Network error");
        }).then(response => {
            if (response.ok) {
                const statusChip = document.querySelector('.status');

                document.querySelectorAll('.actions a').forEach(element => {
                    element.remove();
                })

                document.querySelector('#closeTaskBtn').remove();
                statusChip.classList.remove('open');
                statusChip.classList.add('canceled');
                statusChip.innerHTML = 'Canceled';
            }
        })
    });
}

addTaskEventHandlers();
