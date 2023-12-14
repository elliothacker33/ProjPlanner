import {icons} from "../const/icons.js";
import {adminPageRegex, teamPageRegex} from "../const/regex.js";
import {getProject} from "../project.js";
import {getAuth} from "../api/user.js";

const currentPath = window.location.pathname;

const isTeamPage = teamPageRegex.test(currentPath);
const idAdminPage = adminPageRegex.test(currentPath);
const project_id = currentPath.match(/\/project\/(\d+)\/team/)[1];
const project = await getProject(project_id);
const auth = getAuth();

export async function createUserItem(user) {
    const userItemSection = document.createElement('section');
    userItemSection.className = 'user-item';
    const userSection = (createUserSection(user));

    if (isTeamPage) {

        const statusSpan = document.createElement('span');
        statusSpan.className = 'status';
        if (project && project.user_id === user.id) {
            statusSpan.className += ' coordinator';
            statusSpan.innerHTML = icons['coordinator'] + 'Coordinator';
        } else {
            statusSpan.className += ' member';
            statusSpan.innerHTML = icons['member'] + 'Member';
        }
        userSection.appendChild(statusSpan);
    }
    userItemSection.appendChild(userSection);

    if (isTeamPage && (project.user_id !== user.id && auth.id === project.user_id)) {
        userItemSection.appendChild(createActionsSection(user, ['promote', 'remove']));
    } else if (idAdminPage && auth.is_admin) {
        userItemSection.appendChild(createActionsSection(user, ['edit', 'block', 'delete']));
    }

    return userItemSection;
}

function createUserCard(user) {
    const userCard = document.createElement('section');
    userCard.classList.add('userCard');
    userCard.innerHTML = ` <img class="icon avatar" src="/img/default_user.png" alt="default user icon">
                          <section class="info">
                              <h3>${user.name}</h3>
                              <h5>${user.email}</h5>
                          </section>`;
    return userCard;
}

function createUserSection(user) {
    const userSection = document.createElement('section');
    userSection.className = 'user';

    const profileLink = document.createElement('a');
    profileLink.href = "/user-profile/" + user.id; // Replace with the actual URL

    profileLink.appendChild(createUserCard(user));
    userSection.appendChild(profileLink);
    return userSection;
}

function createActionsSection(user, actions) {
    const actionsSection = document.createElement('section');
    actionsSection.className = 'actions';

    for (let action of actions) {
        const span = document.createElement('span');
        span.className = action;
        span.id = user.id;
        span.innerHTML = icons['user-' + action];
        actionsSection.appendChild(span);
    }
    return actionsSection;
}


