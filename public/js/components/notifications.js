import {getDateString} from "../utils.js";
import {
    seenCommentNotifications,
    seenForumNotifications,
    seenInviteNotifications,
    seenProjectNotifications,
    seenTaskNotifications
} from "../api/notifications.js";

export function notificationSection(title, notifications) {
    const section = document.createElement('section');
    section.classList.add('notificationSection');
    section.classList.add('title-'+title);

    const header = document.createElement('header');

    const titleElement = document.createElement('h3');
    titleElement.textContent = title;

    const notificationCount = document.createElement('span');
    notificationCount.classList.add('number')

    const chevronUp = document.createElement('span');
    chevronUp.innerHTML = '<i class="fas fa-chevron-up"></i>';


    const notificationsList = document.createElement('section');
    notificationsList.className = ' notifications-list';
    let unseen =0;
    notifications.forEach(notification => {
        if(!notification.seen) unseen++;
        if(title ==='Project') notificationsList.insertBefore(projectNotificationCard(notification,notification.project),notificationsList.firstChild);
        else if(title ==='Invite') notificationsList.insertBefore(projectNotificationCard(notification,notification.project),notificationsList.firstChild);
        else if(title === 'Task') notificationsList.insertBefore(taskNotificationCard(notification,notification.task),notificationsList.firstChild);
        else if( title === 'Forum') notificationsList.insertBefore(projectNotificationCard(notification,notification.post.project),notificationsList.firstChild);
        else if(title=== 'Comment') notificationsList.insertBefore(taskNotificationCard(notification,notification.comment.task),notificationsList.firstChild);
    });
    notificationCount.textContent = unseen.toString();
    header.appendChild(titleElement);
    header.appendChild(notificationCount);
    header.appendChild(chevronUp);

    header.addEventListener('click',(e)=>{
        const i= header.querySelector('i');
        i.classList.toggle('fa-chevron-down');
        notificationsList.classList.toggle('hidden');
        seenProjectNotifications().then();
        if(title ==='Project') seenProjectNotifications().then();
        else if(title ==='Invite') seenInviteNotifications().then();
        else if(title === 'Task') seenTaskNotifications().then();
        else if( title === 'Forum') seenForumNotifications().then();
        else if(title=== 'Comment') seenCommentNotifications().then();

    })
    section.appendChild(header);
    // Append the notifications list to the main section
    section.appendChild(notificationsList);

    // Append the main section to the document body (you can change this based on your needs)
    return section
}

export function projectNotificationCard(notification,project) {
    // Create the main section element
    const notificationCard = document.createElement('section');
    notificationCard.className = 'notificationCard projectNotification';

    // Create the anchor element
    const anchor = document.createElement('a');

    // Create the header element
    const header = document.createElement('header');

    // Create the h4 element for the project name
    const projectName = document.createElement('h4');
    projectName.textContent = project.title; // Replace with the actual property from your notification object

    // Create the i element for the check icon
    const checkIcon = document.createElement('i');
    if(!notification.seen)checkIcon.className = 'fa-solid fa-check';
    else checkIcon.className = 'fa-solid fa-check-double';

    // Append project name and check icon to the header
    if(notification.seen) header.classList.add('seen');
    header.appendChild(projectName);
    header.appendChild(checkIcon);

    // Create the section element for the message
    const messageSection = document.createElement('section');
    messageSection.textContent = notification.description; // Replace with the actual property from your notification object

    // Create the footer element for the date
    const footer = document.createElement('footer');
    footer.textContent = getDateString(notification.notifications_date) ; // Replace with the actual property from your notification object

    // Append header, message, and footer to the anchor
    anchor.appendChild(header);
    anchor.appendChild(messageSection);
    anchor.appendChild(footer);

    // Append the anchor to the main section
    notificationCard.appendChild(anchor);

    return notificationCard;
}
export function taskNotificationCard(notification,task) {
    // Create the main section element
    const notificationCard = document.createElement('section');
    notificationCard.className = 'notificationCard projectNotification';

    // Create the anchor element
    const anchor = document.createElement('a');

    // Create the header element
    const header = document.createElement('header');
    const info = document.createElement('section');
    info.classList.add('info');
    // Create the h4 element for the project name
    const projectName = document.createElement('h4');
    projectName.textContent = task.project.title; // Replace with the actual property from your notification object
    const  taskName = document.createElement('h6');
    taskName.textContent = task.title;
    info.append(projectName);
    info.append(taskName);
    // Create the i element for the check icon
    const checkIcon = document.createElement('i');
    if(!notification.seen)checkIcon.className = 'fa-solid fa-check';
    else checkIcon.className = 'fa-solid fa-check-double';

    // Append project name and check icon to the header
    if(notification.seen) header.classList.add('seen');
    header.appendChild(info);
    header.appendChild(checkIcon);

    // Create the section element for the message
    const messageSection = document.createElement('section');
    messageSection.textContent = notification.description; // Replace with the actual property from your notification object

    // Create the footer element for the date
    const footer = document.createElement('footer');
    footer.textContent = getDateString(notification.notifications_date) ; // Replace with the actual property from your notification object

    // Append header, message, and footer to the anchor
    anchor.appendChild(header);
    anchor.appendChild(messageSection);
    anchor.appendChild(footer);

    // Append the anchor to the main section
    notificationCard.appendChild(anchor);

    return notificationCard;
}

export function updateNumbers(type){
    let number =document.querySelector('.title-'+type+'.notificationSection header .number');
    number.innerHTML = parseInt(number.innerHTML)+1;
    const notification = document.querySelector('body > header .notifications .number');
    notification.innerHTML = parseInt(notification.innerHTML)+1;

}
export function calculateNumbers(){
    const notification = document.querySelector('body > header .notifications .number');
    let n=0;
    let number = document.querySelector('.title-Project.notificationSection header .number');
    n+= parseInt(number.innerHTML);
    number = document.querySelector('.title-Task.notificationSection header .number');
    n+= parseInt(number.innerHTML);
    number = document.querySelector('.title-Invite.notificationSection header .number');
    n+= parseInt(number.innerHTML);
    number = document.querySelector('.title-Forum.notificationSection header .number');
    n+= parseInt(number.innerHTML);
    number = document.querySelector('.title-Comment.notificationSection header .number');
    n+= parseInt(number.innerHTML);
    notification.innerHTML=n;

}



