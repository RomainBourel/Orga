import Modal from '../Modal';
import SearchProductBar from './SearchProductBar';
class ProductForm {
    constructor() {
        this.buttonCreate = document.querySelector('#add-product');
        this.init();
    }
    init() {
        this.buttonCreate.addEventListener('click', this.onClickMakeNew);
    }
    getNameInput() {
        return document.querySelector('#product_form_name');
    }
    getFormData() {
        return new FormData(document.querySelector('[name=product_form]'));
    }
    onClickMakeNew = ({target}) => {
        const url = target.dataset.url;
        fetch(url, {
            method: "POST",
            credentials: "include",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(response => response.text())
            .then((data) => {
                Modal.body.innerHTML = data;
                Modal.transformFormButton(url);
                Modal.getFormButton().addEventListener("click", this.onClickCreateProduct);
               this.getNameInput().value = SearchProductBar.input.value;
            })
    }
    onClickCreateProduct = ({target}) => {
        fetch(target.dataset.url, {
            method: "POST",
            body:this.getFormData(),
            credentials: "include",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(response => response.json())
            .then((data) => {
                SearchProductBar.search(this.getNameInput().value, data.response);
            })
    }
}
export default new ProductForm();
