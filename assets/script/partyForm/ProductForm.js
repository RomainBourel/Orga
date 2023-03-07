import Modal from '../Modal';
import SearchProductBar from './SearchProductBar';
export default class ProductForm {
    constructor() {
        this.buttonCreate = document.querySelector('#add-product');
        this.searchInput = document.querySelector('#search-product');
        this.nameInput = document.querySelector('#product_form_name')
        this.descriptionInput = document.querySelector('#product_form_description')
        this.pictureInput = document.querySelector('#product_form_picture')
        this.url = this.buttonCreate.dataset.url;
        this.isModalCreated = false;
        this.init();
    }
    init() {
        this.buttonCreate.addEventListener('click', this.onClickInitModal);
    }
    getNameInput() {
        return document.querySelector('#product_form_name');
    }
    getFormData() {
        return new FormData(document.querySelector('[name=product_form]'));
    }
    onClickInitModal = () => {
        if (!this.isModalCreated) {
            new Modal(this.onClickCreateProduct);
            this.isModalCreated = true;
        }
        this.nameInput.value = this.searchInput.value;
        this.descriptionInput.value = '';
        this.pictureInput.value = '';
    }
    onClickCreateProduct = (e) => {
        e.preventDefault();
        fetch(this.url, {
            method: "POST",
            body:this.getFormData(),
            credentials: "include",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(response => response.json())
            .then((data) => {
                if (400 === data.code) {
                    const modalContentDynamic = document.querySelector('#modal-content--dynamic');
                    modalContentDynamic.innerHTML = data.response.content;
                    const submitButton = modalContentDynamic.querySelector('button[type="submit"]');
                    submitButton.addEventListener('click', this.onClickCreateProduct);
                    submitButton.classList.add('btn__modal');
                    return;
                }
                Modal.closeModal();
                SearchProductBar.search(data.response);
                this.searchInput.value = '';
            })
    }
}
