import Maker from '../Maker.js';
class Product {
    initOne(id) {
        if (this.isAlreadyAdding(id)) {
            this.takeActualValue(id);
        }
        document.querySelector(`#add-product-${id}`).addEventListener('click', this.onClickAdd);
        document.querySelector(`#remove-product-${id}`).addEventListener('click', this.onClickRemove);
    }
    initQuantityInput(id) {
        this.getQuantityInputById(id).dataset.id = id;
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
        this.add(target.dataset.productId, target.dataset.productName);
    }
    onClickRemove = ({target}) => {
        const id = target.dataset.productId
        if (0 === +this.getNumberById(id).innerText) {
            return;
        }
        this.remove(id);
    }
    add(id, name) {
        this.getNumberById(id).innerText ++;
        if (!this.isAlreadyAdding(id)) {
            this.getList().append(this.getFormTemplate(id));
            this.getFormById(id).insertBefore(Maker.element('h3', name), this.getFormById(id).firstElementChild);
            this.initQuantityInput(id)
            this.getQuantityInputById(id).addEventListener('input', ({target}) => {
                this.getNumberById(id).innerHTML = target.value;
            });
        }
        this.getQuantityInputById(id).value = this.getNumberById(id).innerText;
        this.hiddenProductField(id);
        this.setProductFieldOption(id, name);
    }
    remove(id) {
        this.getNumberById(id).innerText  --;
        if (0 === +this.getNumberById(id).innerText) {
            this.getFormById(id).remove();
            return;
        }
        this.getQuantityInputById(id).value = this.getNumberById(id).innerText;
    }
}
export default new Product();
