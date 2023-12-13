import {encodeForAjax, sendAjaxRequest} from "./app.js";

const teamPageRegex = /^\/project\/(\d+)\/team$/;
const currentPath = window.location.pathname;

const auth_response = await sendAjaxRequest("GET", "/api/auth");
const auth = await auth_response.json();

const userList = document.querySelector('.users');

const searchBar = document.getElementById('search-bar');

searchBar.addEventListener('input', async (e) => {

    const project_id = currentPath.match(/\/project\/(\d+)\/team/)[1];
    const project_query = encodeForAjax({'project': project_id});
    const project = await sendAjaxRequest("GET", "/api/projects?" + project_query);
    const res = await project.json();
    const query = encodeForAjax({"query": searchBar.value}) + "&" + encodeForAjax({"project": project_id});
    sendAjaxRequest("GET", "/api/users?" + query).catch(() => {
        console.error("Network error");
    }).then(async response => {
        const data = await response.json();
        await updateUserTable(data, res);
    }).catch(() => {
        console.error('Error parsing JSON');
    });
});

async function updateUserTable(users, project) {
    const userList = document.querySelector('.users');
    userList.innerHTML = '';
    for (let i = 0; i < users.length; i++) {
        await userList.appendChild(await createUserItemSection(users[i], project));

    }
}

async function createUserItemSection(user, project) {
    const userItemSection = document.createElement('section');
    userItemSection.className = 'user-item';

    const userSection = document.createElement('section');
    userSection.className = 'user';

    const profileLink = document.createElement('a');
    profileLink.href = "/user-profile/" + user.id; // Replace with the actual URL
    const userCard = document.createElement('section');
    userCard.classList.add('userCard');
    userCard.innerHTML = ` <img class="icon avatar" src="/img/default_user.png" alt="default user icon">
                          <section class="info">
                              <h3>${user.name}</h3>
                              <h5>${user.email}</h5>
                          </section>`;
    profileLink.appendChild(userCard);

    userSection.appendChild(profileLink);

    const statusSpan = document.createElement('span');
    statusSpan.className = 'status';

    if (project && project.user_id === user.id) {
        statusSpan.className += ' coordinator';
        statusSpan.innerHTML = '<i class="fa-solid fa-user-tie"></i> Coordinator';
    } else {
        statusSpan.className += ' member';
        statusSpan.innerHTML = '<i class="fa-solid fa-user"></i> Member';
    }

    userSection.appendChild(statusSpan);
    userItemSection.appendChild(userSection);

    // Check if the user can be updated
    if (project && project.user_id !== user.id && auth.id === project.user_id ) {
        let actionsSection = document.createElement('section');
        actionsSection.className = 'actions';

        const promoteSpan = document.createElement('span');
        promoteSpan.className = 'promote';
        promoteSpan.id = user.id;
        promoteSpan.innerHTML = '<i class="fa-solid fa-user-tie"></i>';

        const deleteSpan = document.createElement('span');
        deleteSpan.className = 'delete';
        deleteSpan.id = user.id;
        deleteSpan.innerHTML = '<i class="fa-solid fa-user-xmark"></i>';

        actionsSection.appendChild(promoteSpan);
        actionsSection.appendChild(deleteSpan);
        userItemSection.appendChild(actionsSection);
    }


    return userItemSection;
}


