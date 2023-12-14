import {sendAjaxRequest, encodeForAjax} from './app.js'

const currentPath = window.location.pathname;

const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('input', (e) => {
    const input = searchBar.value;
    const encodedInput = encodeForAjax({"query": searchBar.value, "project": currentPath.split('/')[2]});
    const url = input == '' ? currentPath : '/api/tasks?' + encodedInput;

    sendAjaxRequest("GET", url).catch(() => {
        console.error("Network error");
    }).then(async response => {
        const data = await response.json();
        if (response.ok) {
            updateSearchedTasks(data);
        } else {
            console.error(`Error ${response.status}: ${data.error}`);
        }
    }).catch(() => {
        console.error('Error parsing JSON');
    });
});

function updateSearchedTasks(data) {
    let tasksSection = document.querySelector('section.tasks');
    tasksSection.innerHTML = '';

    data.forEach(task => {
        const divWrapper = document.createElement('div');
        const taskSection = document.createElement('section');
        const statusSection = document.createElement('section');
        const taskAnchor = document.createElement('a');

        divWrapper.classList.add('tasks');

        taskSection.classList.add('task');
        taskAnchor.setAttribute('href', `/project/${currentPath.split('/')[2]}/task/${task.id}/`);
        taskAnchor.textContent = task.title;
        taskSection.appendChild(taskAnchor);
        statusSection.classList.add('status');
        statusSection.textContent = task.status;

        divWrapper.appendChild(taskSection);
        divWrapper.appendChild(statusSection);

        tasksSection.appendChild(divWrapper);
    });
}
