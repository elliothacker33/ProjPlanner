const header = document.querySelector('header');
const content = document.querySelector('body');

content.style.paddingTop = (header.clientHeight).toString() + 'px';

const currentPath = window.location.pathname;
const projectHomePage = /^\/project\/[0-9]+$/.test(currentPath);
const projectTeamPage = /^\/project\/[0-9]+\/team$/.test(currentPath);
const projectTaskPage = (/^\/project\/[0-9]+\/tasks$/).test(currentPath);
if(projectTaskPage)document.querySelector('#projectTasks').classList.add('selected')
else if (projectTeamPage)document.querySelector('#projectTeam').classList.add('selected')
else if(projectHomePage) document.querySelector('#projectHome').classList.add('selected')

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}



  