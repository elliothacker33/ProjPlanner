import {sendAjaxRequest} from "../app.js";

export async function seenProjectNotifications() {
    const notification = await sendAjaxRequest("PUT", "/api/projectNotifications/seen");
    return await notification.json();
}