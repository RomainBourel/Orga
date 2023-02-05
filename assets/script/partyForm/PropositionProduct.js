import Maker from '../Maker.js';
import ProductParty from "./ProductParty";
import ProductPartyList from "./ProductPartyList";
export default class PropositionProduct {
    constructor(product, isNewProduct = false) {
        this.id = product.dataset.id;
        this.name = product.dataset.name;
        this.unity = product.dataset.unity;
        this.quantityInput = document.querySelector("#search-product-quantity-input-" + this.id);
        if (ProductPartyList.isInList(this.id)) {
            this.quantityInput.value = ProductPartyList.getQuantityInput(this.id);
        }
        this.buttonAdd = document.querySelector(`#add-product-${this.id}`);
        this.buttonRemove = document.querySelector(`#remove-product-${this.id}`);
        this.inputQuantity = document.querySelector(`#search-product-quantity-input-${this.id}`);
        this.init();
        if (isNewProduct) {
            this.add();
        }
    }

    init() {
        this.buttonAdd.addEventListener('click', this.onClickAdd);
        this.buttonRemove.addEventListener('click', this.onClickRemove);
        this.inputQuantity.addEventListener('input', this.onInputUpdate);
    }

    onClickAdd = () => {
        this.add();
    }
    onClickRemove = () => {
        if (0 === +this.quantityInput.value) {
            return;
        }
        this.remove();
    }
    onInputUpdate = () => {
        if (0 !== +this.quantityInput.value) {
            if (!ProductPartyList.isInList(this.id)) {
                const data = {
                    id: this.id,
                    name: this.name,
                    unity: this.unity
                }
                new ProductParty(data);
            }
            this.updateProductPartyQuantity()
        } else {
            if (ProductPartyList.isInList(this.id)) {
                this.delete();
            }
        }
    }
    add() {
        this.quantityInput.value++;

        if (1 === +this.quantityInput.value && !ProductPartyList.isInList(this.id)) {
            const data = {
                id: this.id,
                name: this.name,
                unity: this.unity
            }
            new ProductParty(data);
        }
        this.updateProductPartyQuantity();
    }
    remove() {
        this.quantityInput.value--;
        if (0 === +this.quantityInput.value) {
            this.delete();
            return;
        }
        this.updateProductPartyQuantity()
    }

    delete() {
        const productParty = ProductParty.getProductPartyCard(this.id);
        productParty.classList.add('hidden');
        productParty.querySelector(`[id$="quantity"]`).value = this.quantityInput.value;
    }

    updateProductPartyQuantity() {
        const productParty = ProductParty.getProductPartyCard(this.id);
        productParty.classList.remove('hidden');
        productParty.querySelector(`[id$="quantity"]`).value = this.quantityInput.value;
    }
}
