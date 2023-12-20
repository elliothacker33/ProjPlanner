import {projectHomePageRegex, projectTeamPageRegex, projectTaskPageRegex } from "./const/regex.js";
import {getProjects} from "./api/user.js";

const header = document.querySelector('header');
const content = document.querySelector('body');

content.style.paddingTop = (header.clientHeight).toString() + 'px';

const currentPath = window.location.pathname;
const projectHomePage = projectHomePageRegex.test(currentPath);
const projectTeamPage = projectTeamPageRegex.test(currentPath);
const projectTaskPage = projectTaskPageRegex.test(currentPath);

if(projectTaskPage)document.querySelector('#projectTasks').classList.add('selected')
else if (projectTeamPage)document.querySelector('#projectTeam').classList.add('selected')
else if(projectHomePage) document.querySelector('#projectHome').classList.add('selected')

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

// realtime-notifications.js

const subscribeToProjectChannels = (projects) => {
    const pusher = new Pusher("8afd0da3d4993e84efef", {
        cluster: 'eu',
        encrypted: true,
    });

    projects.forEach(project => {
        console.log(project.id)
        const channel = pusher.subscribe('project.' + project.id);
        channel.bind('App\\Events\\ProjectNotification', function (data) {
            console.log('New project notification:', data.message);
            // Handle the new notification on the frontend for the specific project
        });
    });
};
const projects = await getProjects();

subscribeToProjectChannels(projects);



