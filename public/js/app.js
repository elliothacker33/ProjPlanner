import {projectHomePageRegex, projectTeamPageRegex, projectTaskPageRegex } from "./const/regex.js";
import {getNotifications, getProjects} from "./api/user.js";
import {notificationSection, projectNotificationCard} from "./components/notifications.js";

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
        channel.bind('notification-project', function (data) {
            const project_section =document.querySelector('.notificationSection.title-'+data.type);
            project_section.insertBefore(projectNotificationCard(data),project_section.firstChild);
        });
    });
};

const subscribeToTasksChannels = (tasks) => {
    const pusher = new Pusher("8afd0da3d4993e84efef", {
        cluster: 'eu',
        encrypted: true,
    });

    tasks.forEach(task => {
        const channel = pusher.subscribe('task.' + task.id);
        channel.bind('notification-task', function (data) {
            const project_section =document.querySelector('.notificationSection.title-'+data.type);
            project_section.insertBefore(projectNotificationCard(data),project_section.firstChild);
        });
    });
};
const subscribeToUserChannels = (user) => {
    const pusher = new Pusher("8afd0da3d4993e84efef", {
        cluster: 'eu',
        encrypted: true,
    });

        const channel = pusher.subscribe('user.' + user.id);
        channel.bind('notification-user', function (data) {
            const project_section =document.querySelector('.notificationSection.title-'+data.type);
            project_section.insertBefore(projectNotificationCard(data),project_section.firstChild);
        });
};
const projects = await getProjects();

subscribeToProjectChannels(projects);

console.log(await getNotifications());
const notificationsContainer = document.querySelector('.notificationsContainer');
notificationsContainer.append(notificationSection('Project',(await getNotifications()).projectNotifications));

