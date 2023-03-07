export default class Modal {
    constructor(buttonCallback = null) {
        this.modal = document.querySelector('#modal');
        this.content = document.querySelector('#modal-content');
        this.openModalButton = document.querySelector(this.modal.dataset.openModalButton);
        this.closeModalButton = document.querySelector('#modal-close-button');
        this.init(buttonCallback);
    }

    init(buttonCallback) {
        this.modal.addEventListener('click', (e) => this.onClickCloseModal(e, this.modal));
        this.closeModalButton.addEventListener('click', (e) => this.onClickCloseModal(e, this.closeModalButton));
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
            Modal.closeModal();
        }
    }

    static closeModal() {
        document.querySelector('#modal').classList.remove('modal--open');
        document.querySelector('#modal-content').classList.add('hidden');
    }
}
