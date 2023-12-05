import {sendAjaxRequest, encodeForAjax} from './app.js'

const currentPath = window.location.pathname;

const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('input', (e) => {
    let input = searchBar.value;

    const encodedInput = encodeForAjax({"query": input, "project": currentPath.split('/')[2]})
    sendAjaxRequest("GET", "/api/tasks?" + encodedInput, '', updateSearchedTasks); 
});

export function updateSearchedTasks() {
    let tasksSection = document.querySelector('section.tasks');
    tasksSection.innerHTML = '';
    const data =  JSON.parse(this.responseText)

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

