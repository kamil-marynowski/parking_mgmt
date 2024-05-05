function showModal(id)
{
    clearErrors();

    const modal = document.querySelector(id);
    modal.classList.add('show');

    const body = document.querySelector('body');
    body.classList.add('modal-show');
}

function hideModal(id)
{
    const modal = document.querySelector(id);
    modal.classList.remove('show');

    const body = document.querySelector('body');
    body.classList.remove('modal-show');
}

const openModalBtns = document.querySelectorAll('.open-modal');
for (const btn of openModalBtns) {
    btn.addEventListener('click', () => {
        const modalId = btn.dataset.modalId;
        showModal(modalId);
    });
}

const closeModalBtns = document.querySelectorAll('.close-modal-btn');
for (const btn of closeModalBtns) {
    btn.addEventListener('click', () => {
        const modalId = btn.dataset.modalId;
        hideModal(modalId);
    });
}