import Maker from "../Maker";
import ProductParty from "./ProductParty";

export default class ProductPartyList {
    constructor() {
        this.init();
    }

    init() {
        document.querySelectorAll('div[id^=party_form_productsParty_]').forEach((productParty) => {
            const data = {
                id: productParty.dataset.productId,
                name: productParty.dataset.name,
                unity: productParty.dataset.unity,
            }
            new ProductParty(data, true);
        });
    }

    static getCurrentId() {
        return document.querySelector('#products-list').dataset.currentId ++;
    }

    static getList() {
        return document.querySelector('#products-list');
    }

    static getQuantityInput(productId) {
        return document.querySelector(`[data-product-id="${productId}"]`).querySelector('[id$=quantity]').value;
    }

    static isInList(productId) {
        return !!document.querySelector(`[data-product-id="${productId}"]`);
    }

    static getFormTemplate(productId) {
        const element = Maker.nodeElementByString(this.getList().dataset.template.replace(/__name__/g, ProductPartyList.getCurrentId()));
        element.dataset.productId = productId;
        return element;
    }
}