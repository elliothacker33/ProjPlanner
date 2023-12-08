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
            console.error(`Error ${response.status}: ${JSON.stringify(data.error)}`);
        }
    }).catch(() => {
        console.error('Error parsing JSON');
    });
});

function updateSearchedTasks(data) {
    let tasksSection = document.querySelector('section.tasks');
    tasksSection.innerHTML = '';
    data.forEach(task => {
        tasksSection.appendChild(create_task_card(task));
    });
}

function create_task_card(task){
    // Create elements
    const taskCard = document.createElement('section'); // task card main component
    const ul = document.createElement('ul'); // list with main inf
    const header_li = document.createElement('li'); // list element with the header
    const header = document.createElement('header'); // header
    const h3 = document.createElement('h3'); // task title
    const a = document.createElement('a'); // link to task page
    const status = document.createElement('span'); // task status
    const deadline_li = document.createElement('li'); // deadline
    const h6 = document.createElement('h6'); // extra inf

    // Assign classes
    taskCard.classList.add('taskCard');
    status.classList.add('status');
    status.classList.add(task.status);
    deadline_li.classList.add('deadLine');

    // Assign text and attributes
    a.setAttribute('href', `/project/${currentPath.split('/')[2]}/task/${task.id}/`);
    a.textContent=task.title;
    if (task.status === 'open') status.innerHTML = ' <i class="fa-solid fa-folder-open"></i> Open ';
    else if (task.status ==='closed') status.innerHTML = ' <i class="fa-solid fa-folder-closed"></i> Closed ';
    else status.innerHTML = ' <i class="fa-solid fa-ban"></i> Canceled ';
    if(task.deadline){
        deadline_li.innerHTML ='<i class="fa-solid fa-clock"></i> '+ convert_date(task.deadline);
    }
    else deadline_li.innerHTML = '<i class="fa-solid fa-clock"></i> There is no deadline'
    h6.innerHTML ='#'+task.id+ ' Created by '+ task.creator.name+' on '+ convert_date(task.starttime);

    // Append elements
    h3.appendChild(a);
    header.appendChild(h3);
    header.appendChild(status);
    header_li.appendChild(header)
    ul.appendChild(header_li);
    ul.appendChild(deadline_li);
    taskCard.appendChild(ul);
    taskCard.appendChild(h6);

    return taskCard;
}
function convert_date(originalDateString){
    const originalDate = new Date(originalDateString);
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const formatter = new Intl.DateTimeFormat('en-UK', options);
    const formattedDateString = formatter.format(originalDate).replace(/\//g, '-');
    return formattedDateString;
}

