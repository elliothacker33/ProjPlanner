import {projectHomePageRegex, projectTeamPageRegex, projectTaskPageRegex, projectTagsPageRegex} from "./const/regex.js";

const currentPath = window.location.pathname;

const projectHomePage = /^\/project\/[0-9]+$/.test(currentPath);
const projectTeamPage = /^\/project\/[0-9]+\/team$/.test(currentPath);
const projectTaskPage = (/^\/project\/[0-9]+\/tasks$/).test(currentPath);
const projectFilesPage = (/^\/project\/[0-9]+\/files$/).test(currentPath);
if(projectTaskPage)document.querySelector('#projectTasks').classList.add('selected')
else if (projectTeamPage)document.querySelector('#projectTeam').classList.add('selected')
else if(projectHomePage) document.querySelector('#projectHome').classList.add('selected')
else if(projectFilesPage) document.querySelector('#projectFiles').classList.add('selected')

function buildFetchOptions(method, data) {
    const options = {
        method: method,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
        }
    };

    if (method != "GET")
        options.body = encodeForAjax(data);

    return options;
}

export function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

export async function sendAjaxRequest(method, url, data) {
    return await fetch(url, buildFetchOptions(method, data));
}