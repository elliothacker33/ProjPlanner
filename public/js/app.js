<<<<<<< HEAD
import {
    projectHomePageRegex,
    projectTeamPageRegex,
    projectTaskPageRegex,
    adminUserPageRegex,
    adminProjectPageRegex
} from "./const/regex.js";
=======
import {projectHomePageRegex, projectTeamPageRegex, projectTaskPageRegex, projectTagsPageRegex} from "./const/regex.js";
>>>>>>> main

const currentPath = window.location.pathname;
const projectHomePage = projectHomePageRegex.test(currentPath);
const projectTeamPage = projectTeamPageRegex.test(currentPath);
const projectTaskPage = projectTaskPageRegex.test(currentPath);
<<<<<<< HEAD
const adminUsersPage = adminUserPageRegex.test(currentPath);
const projectAdminPage = adminProjectPageRegex.test(currentPath);
=======
const projectTagsPage = projectTagsPageRegex.test(currentPath);
>>>>>>> main

console.log(adminUsersPage)
if(projectTaskPage)document.querySelector('#projectTasks').classList.add('selected')
else if (projectTeamPage)document.querySelector('#projectTeam').classList.add('selected')
else if(projectHomePage) document.querySelector('#projectHome').classList.add('selected')
<<<<<<< HEAD
else if(adminUsersPage) document.querySelector('#adminUsersPage').classList.add('selected')
else if( projectAdminPage) document.querySelector('#adminProjectsPage').classList.add('selected')

=======
else if(projectTagsPage) document.querySelector('#projectTags').classList.add('selected')
>>>>>>> main
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