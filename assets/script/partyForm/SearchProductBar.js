import Product from './Product.js';
class SearchProductBar {
    constructor() {
        this.input = document.querySelector('#search-product');
        this.formData = new FormData();
        this.propositionList = document.querySelector('#product-proposition-table');
        this.init();
    }
    init() {
        this.input.addEventListener('input', this.onInputSearch)
    }
    onInputSearch = (e) => {
        if (2 < this.input.value.length) {
            this.search(this.input.value);
        }
    }
    search(value, productData = null) {
        this.formData.delete('id');
        this.formData.set('q', value)
        if (productData) {
            this.formData.set('id', productData.id);
        }
        fetch(this.input.dataset.url, {
            method: "POST",
            body: this.formData,
        })
            .then(response => response.json())
            .then((data) => {
                this.propositionList.innerHTML = data.response.content;
                Product.getAll().forEach(function(currentProduct) {Product.initOne(currentProduct.dataset.id)})
                if (productData) {
                    Product.add(productData.id, productData.name);
                }
            })
    }
}
export default new SearchProductBar();
