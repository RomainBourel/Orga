import Product from './ProductParty.js';
import PropositionProduct from "./PropositionProduct";
export default class SearchProductBar {
    constructor() {
        this.input = document.querySelector('#search-product');
        this.init();
    }
    init() {
        this.input.addEventListener('input', this.onInputSearch)
    }
    onInputSearch = () => {
        if (2 < this.input.value.length) {
            SearchProductBar.search();
        }
    }
    static getAllSearchProduct() {
        return document.querySelectorAll('[id^=card-search-product-]');
    }
    static search(productData = null) {
        const formData = new FormData();
        const input = document.querySelector('#search-product');
        const propositionList = document.querySelector('#product-proposition-table');
        formData.set('q', input.value)
        let isNewProduct = false;
        if (productData) {
            formData.set('id', productData.id);
            isNewProduct = true;
        }
        fetch(input.dataset.url, {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then((data) => {
                propositionList.innerHTML = data.response.content;
                SearchProductBar.getAllSearchProduct().forEach(function(currentProduct) {
                    new PropositionProduct(currentProduct, isNewProduct);
                })
            })
    }

    static isInSearchList(productId) {
        return !!document.querySelector('#card-search-product-' + productId);
    }

    static updateQuantityOfProduct(productId, quantity) {
        document.querySelector('#search-product-quantity-input-' + productId).value = quantity;
    }
}

