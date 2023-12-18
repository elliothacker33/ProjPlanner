import {sendAjaxRequest} from "../app.js";

export async function getAuth() {
    const auth_response = await sendAjaxRequest("GET", "/api/auth");
    return await auth_response.json();
}