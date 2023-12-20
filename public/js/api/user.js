import {sendAjaxRequest} from "../app.js";

export async function getAuth() {
    const auth_response = await sendAjaxRequest("GET", "/api/auth");
    return await auth_response.json();
}

export async function getProjects(){
    const auth_response = await sendAjaxRequest("GET", "/api/projects");
    return await auth_response.json();
}
export async function getNotifications(){
    const notification = await sendAjaxRequest("GET", "/api/notifications");
    return await notification.json();
}