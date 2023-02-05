export default class Modal {
    constructor(buttonCallback = null) {
        this.modal = document.querySelector('#modal');
        this.content = document.querySelector('#modal-content');
        this.openModalButton = document.querySelector(this.modal.dataset.openModalButton);
        this.init(buttonCallback);
    }

    init(buttonCallback) {
        this.modal.addEventListener('click', (e) => this.onClickCloseModal(e, this.modal));
        this.modal.querySelectorAll('button').forEach((button) => {
            button.addEventListener('click', (e) => this.onClickCloseModal(e, button));
        });
        this.openModalButton.addEventListener('click', this.onClickOpenModal);
        this.openModal();
        if (buttonCallback) {
            const submitButton = this.content.querySelector('button[type="submit"]');
            submitButton.classList.add('btn__modal');
            submitButton.addEventListener('click', buttonCallback);
        }

    }

    onClickOpenModal = () => {
        this.openModal();
    }

    openModal() {
        this.modal.classList.add('modal--open');
        this.content.classList.remove('hidden');
    }

    onClickCloseModal = ({target}, elementWhoListen) => {
        if (target === elementWhoListen) {
            this.closeModal();
        }
    }

    closeModal() {
        this.modal.classList.remove('modal--open');
        this.content.classList.add('hidden');
    }
}
