export function attachModal(dialog) {
    const closeAnchor = dialog.querySelector('.close-modal');
    const closeIcon = dialog.querySelector('.fa-x');
    const confirmBtn = dialog.querySelector('.modal-confirm');
    const openBtn = document.querySelector('#' + dialog.dataset.openFormId);

    dialog.addEventListener('click', (event) => {
        const modalRect = dialog.getBoundingClientRect();
        const inDialog = (modalRect.top <= event.clientY && event.clientY <= modalRect.top + modalRect.height &&
            modalRect.left <= event.clientX && event.clientX <= modalRect.left + modalRect.width);
        if (!inDialog) {
            dialog.close();
        }
    });
    
    openBtn.addEventListener('click', () => {
        dialog.showModal();
        confirmBtn.blur();
    });
    
    closeAnchor.addEventListener('click', () => {
        dialog.close();
    });
    
    closeIcon.addEventListener('click', () => {
        dialog.close();
    });
}
