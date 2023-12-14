import {encodeForAjax, sendAjaxRequest} from "../app.js";
import {createUserItem} from "../components/user.js";

const currentPath = window.location.pathname;
const searchBar = document.getElementById('search-bar');

searchBar.addEventListener('input', async (e) => {
    const matches = currentPath.match(/\/project\/(\d+)\/team/);
    let query = encodeForAjax({"query": searchBar.value});
    if(matches) query+= "&" +encodeForAjax({"project": matches[0]});
    sendAjaxRequest("GET", "/api/users?" + query).catch(() => {
        console.error("Network error");
    }).then(async response => {
        const data = await response.json();

        await updateUserTable(data);
    }).catch(() => {
        console.error('Error parsing JSON');
    });
});

async function updateUserTable(users) {
    const userList = document.querySelector('.users');
    userList.innerHTML = '';
    for (let i = 0; i < users.length; i++) {
        await userList.appendChild(await createUserItem(users[i]));
    }
}

