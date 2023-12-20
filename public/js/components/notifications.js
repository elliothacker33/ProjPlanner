import {getDateString} from "../utils.js";
import {seenProjectNotifications} from "../api/notifications.js";

export function notificationSection(title, notifications) {
    const section = document.createElement('section');
    section.className = 'notificationSection';

    const header = document.createElement('header');

    const titleElement = document.createElement('h3');
    titleElement.textContent = title;

    const notificationCount = document.createElement('span');
    notificationCount.classList.add('number')

    const chevronUp = document.createElement('span');
    chevronUp.innerHTML = '<i class="fas fa-chevron-up"></i>';


    const notificationsList = document.createElement('section');
    notificationsList.className = 'title-'+title+' notifications-list';
    let unseen =0;
    notifications.forEach(notification => {
        if(!notification.seen) unseen++;
        notificationsList.appendChild(projectNotificationCard(notification));
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
    })
    section.appendChild(header);
    // Append the notifications list to the main section
    section.appendChild(notificationsList);

    // Append the main section to the document body (you can change this based on your needs)
    return section
}

export function projectNotificationCard(notification) {
    // Create the main section element
    const notificationCard = document.createElement('section');
    notificationCard.className = 'notificationCard projectNotification';

    // Create the anchor element
    const anchor = document.createElement('a');

    // Create the header element
    const header = document.createElement('header');

    // Create the h4 element for the project name
    const projectName = document.createElement('h4');
    projectName.textContent = notification.project.title; // Replace with the actual property from your notification object

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



