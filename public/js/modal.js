const modal = document.querySelector('#close-task-modal');
const closeAnchor = document.querySelector('.close-modal');
const openBtn = document.querySelector('.open-modal');
const closeIcon = document.querySelector('.fa-x');
const confirmBtn = document.querySelector('.modal-confirm');

modal.addEventListener('click', (event) => {
    const modalRect = modal.getBoundingClientRect();
    const inDialog = (modalRect.top <= event.clientY && event.clientY <= modalRect.top + modalRect.height &&
        modalRect.left <= event.clientX && event.clientX <= modalRect.left + modalRect.width);
    if (!inDialog) {
        modal.close();
    }
});

openBtn.addEventListener('click', () => {
    modal.showModal();
    confirmBtn.blur();
});

closeAnchor.addEventListener('click', () => {
    modal.close();
});

closeIcon.addEventListener('click', () => {
    modal.close();
});
