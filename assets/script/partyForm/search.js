const searhProductInput = document.querySelector('#search-product');
searhProductInput.addEventListener('keyup', onKeyupSearch);
document.querySelector('#add-product').addEventListener('click', onClickCreateProduct);
let newProductId = 1;


function onKeyupSearch(e) {
    const keyToIgnore = [37, 38, 39, 40]
    if (2 < this.value.length && !keyToIgnore.includes(e.keyCode)) {
        const form = new FormData()
        form.set('q', this.value)
        fetch(this.dataset.url, {
            method: "POST",
            body: form,
        })
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                const propositionTable = document.querySelector('#product-proposition-table');
                propositionTable.innerHTML = data.response.content;
                const products = document.querySelectorAll('[id^=search-product-]');
                products.forEach(function(product) {
                    product.querySelector('[id^=add-product]').addEventListener('click', onClickAddProduct);
                    product.querySelector('[id^=remove-product]').addEventListener('click', onClickRemoveProduct);
                })
        })
    }
}

function onClickAddProduct(e) {
    const id = this.dataset.productId;
    const nbProduct = document.querySelector(`#nb-product-${id}`);
    nbProduct.innerText ++;
    const productList = document.querySelector('#products-list');
    if (null === document.querySelector(`#party_form_productsParty_${id}`)) {
        const formProductsParty = makeElement(productList.dataset.template.replace(/__name__/g, id));
        productList.append(formProductsParty);
    }
    document.querySelector(`#party_form_productsParty_${id}_quantity`).value = nbProduct.innerText;
    document.querySelector(`#party_form_productsParty_${id}_product`).value = id;
}
function onClickRemoveProduct(e) {
    const id = this.dataset.productId
    const nbProduct = document.querySelector(`#nb-product-${id}`)
    if (0 < nbProduct.innerHTML) {
        nbProduct.innerHTML --;
        document.querySelector(`#party_form_productsParty_${id}_quantity`).value = nbProduct.innerText;
    }
}

function makeElement(string) {
    const div = document.createElement('div');
    div.innerHTML = string;
    return div.firstElementChild;
}

function onClickCreateProduct(e) {
    fetch(this.dataset.url, {
        method: "POST",
        credentials: "include",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then(response => response.text())
        .then((data) => {
            console.log(data);
            const formProductsParty = makeElement(this.dataset.template.replace(/__name__/g, 'new_' + newProductId++));
            const newProductForm = document.querySelector('#new-product-form');
            newProductForm.innerHTML = data;
            const newProductButton = newProductForm.querySelector('button');
            newProductButton.type = 'button';
            newProductButton.addEventListener("click", onClickMakeNewProduct);
            const productName = document.querySelector('#product_form_name');
            productName.value = searhProductInput.value;
            searhProductInput.value = '';

    })
}

function onClickMakeNewProduct(e) {
    const productForm = document.querySelector('[name=product_form]');
    console.log(productForm);
    const form = new FormData(productForm);
    console.log(productForm.dataset.url);
    fetch(document.querySelector('#new-product-form').dataset.url, {
        method: "POST",
        body: form,
        credentials: "include",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then(response => response.json())
        .then((data) => {
            console.log(data);
    })
}