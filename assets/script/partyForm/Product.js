import Maker from '../Maker.js';
class Product {
    initOne(id) {
        if (this.isAlreadyAdding(id)) {
            this.takeActualValue(id);
        }
        document.querySelector(`#add-product-${id}`).addEventListener('click', this.onClickAdd);
        document.querySelector(`#remove-product-${id}`).addEventListener('click', this.onClickRemove);
        document.querySelector(`#nb-product-${id}`).addEventListener('input', this.onInputUpdate);
    }
    initQuantityInput(id, unity) {
        const quantityInput = this.getQuantityInputById(id);
        quantityInput.dataset.id = id;
        quantityInput.parentElement.querySelector('label').innerText += ` (${unity})`
    }
    getAll() {
        return document.querySelectorAll('[id^=search-product-]');
    }
    getNumberById(id) {
        return document.querySelector(`#nb-product-${id}`);
    }
    getList() {
        return document.querySelector('#products-list');
    }
    getFormTemplate(id) {
        return Maker.elementByString(this.getList().dataset.template.replace(/__name__/g, id));
    }
    getFormById(id) {
        return document.querySelector(`#party_form_productsParty_${id}`);
    }
    getQuantityInputById(id) {
        return document.querySelector(`#party_form_productsParty_${id}_quantity`);
    }
    getProductFieldById(id) {
        return document.querySelector(`#party_form_productsParty_${id}_product`);
    }
    hiddenProductField(id) {
        this.getProductFieldById(id).parentElement.hidden = true;
    }
    getProductFieldOptionById(id) {
        return this.getProductFieldById(id).querySelector('option');
    }
    setProductFieldOption(id, name) {
        const option = this.getProductFieldOptionById(id);
        option.value = id;
        option.innerText = name;
    }
    isAlreadyAdding(id) {
        return !!this.getFormById(id);
    }
    takeActualValue(id) {
        this.getNumberById(id).innerText = this.getQuantityInputById(id).value;
    }
    onClickAdd = ({target}) => {
        this.add(target.dataset.productId, target.dataset.productName, target.dataset.productUnity);
    }
    onClickRemove = ({target}) => {
        const id = target.dataset.productId
        if (0 === +this.getNumberById(id).value) {
            return;
        }
        this.remove(id);
    }
    onInputUpdate = ({target}) => {
        const id = target.dataset.productId;
        if (0 !== +target.value) {
            if (!this.isAlreadyAdding(id)) {
                this.createProductForm(id, target.dataset.productName, target.dataset.productUnity);
            }
            this.updateProductForm(id)
        } else {
            if (this.isAlreadyAdding(id)) {
                this.getFormById(id).remove();
            }
        }
    }
    add(id, name, unity) {
        this.getNumberById(id).value ++;
        if (!this.isAlreadyAdding(id)) {
            this.createProductForm(id, name, unity);
        }
        this.updateProductForm(id);
    }
    remove(id) {
        this.getNumberById(id).value  --;
        if (0 === +this.getNumberById(id).value) {
            this.getNumberById(id).value = null;
            this.getFormById(id).remove();
            return;
        }
        this.updateProductForm(id)
    }
    updateProductForm(id) {
        this.getQuantityInputById(id).value = this.getNumberById(id).value;
    }
    createProductForm(id, name, unity) {
        this.getList().append(this.getFormTemplate(id));
        this.getFormById(id).insertBefore(Maker.element('h3', name), this.getFormById(id).firstElementChild);
        this.initQuantityInput(id, unity);
        this.getQuantityInputById(id).addEventListener('input', ({target}) => {
            this.getNumberById(id).value = target.value;
        });
        this.hiddenProductField(id);
        this.setProductFieldOption(id, name);
    }
}
export default new Product();
