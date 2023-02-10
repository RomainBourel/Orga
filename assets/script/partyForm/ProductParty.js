import Maker from '../Maker.js';
import ProductPartyList from "./ProductPartyList";
import SearchProductBar from "./SearchProductBar";
export default class ProductParty {
    constructor(data, isAlreadyAdding = false) {
        this.id = data.id;
        this.name = data.name;
        this.unity = data.unity;
        if (!isAlreadyAdding) {
            this.createProduct();
        }
        this.card = document.querySelector(`[data-product-id="${this.id}"]`);
        this.init();
    }

    createProduct() {
        ProductPartyList.getList().append(ProductPartyList.getFormTemplate(this.id));
    }

    init() {
        this.initProductTitle();
        this.quantityInput = this.getInput("quantity");
        this.initQuantityLabel();
        this.quantityInput.addEventListener('input', this.onInputUpdate);
        this.setProductId();
        this.initDeleteButton();
    }
    initProductTitle() {
        this.card.insertBefore(Maker.element('h3', this.name), this.card.firstElementChild);
    }

    initDeleteButton() {
        const buttonDelete = Maker.element('button', ProductPartyList.getList().dataset.deleteButtonText, ['btn', 'btn__delete']);
        buttonDelete.addEventListener('click', this.deleteProduct);
        buttonDelete.style.marginTop = '0';
        buttonDelete.type = 'button';
        this.card.appendChild(buttonDelete);
    }

    deleteProduct = () => {
        this.card.classList.add('hidden');
        this.quantityInput.value = 0;
        if (SearchProductBar.isInSearchList(this.id)) {
            SearchProductBar.updateQuantityOfProduct(this.id, 0);
        }
    }

    getInput(inputName) {
        return this.card.querySelector(`[id$="${inputName}"]`);
    }

    initQuantityLabel() {
        this.quantityInput.parentElement.querySelector('label').innerText += ` (${this.unity})`;
    }

    setProductId() {
        this.getInput("product").value = this.id;
    }

    onInputUpdate = () => {
        if (SearchProductBar.isInSearchList(this.id)) {
            SearchProductBar.updateQuantityOfProduct(this.id, this.quantityInput.value);
        }
    }

    static getProductPartyCard(id) {
        return document.querySelector(`[data-product-id="${id}"]`);
    }
}
