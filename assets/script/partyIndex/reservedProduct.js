import {makeFlash} from "../flashMessage";
export default class ReservedProduct {
    constructor() {
        this.reservedProductButton = document.querySelectorAll('[id^=reserved-product-button-]');
        this.buyProductButton = document.querySelectorAll('[id^=buy-product-button-]');
        this.unreservedProductButton = document.querySelectorAll('[id^=unreserved-product-button-]');
        this.unbuyProductButton = document.querySelectorAll('[id^=unbuy-product-button-]');
        this.bindButtons();
    }

    initBuyButton() {
        this.buyProductButton = document.querySelectorAll('[id^=buy-product-button-]');
        this.unbuyProductButton = document.querySelectorAll('[id^=unbuy-product-button-]');
        this.bindBuyButtons();
    }

    bindButtons()
    {
        this.reservedProductButton.forEach((button) => {
            button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
        });

        this.unreservedProductButton.forEach((button) => {
            button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
        });
        this.bindBuyButtons();
    }

    bindBuyButtons() {
        this.buyProductButton.forEach((button) => {
        button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
    });
        this.unbuyProductButton.forEach((button) => {
            button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
        });
    }
    onClickCallLink = (e, button) => {
        e.preventDefault();
        if ('true' === button.dataset.listener) {
            return;
        }
        this.callLink(button.href, button);
        button.dataset.listener = 'true';
    }

    callLink(url, button = null) {
        fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                if (200 === response.status) {
                    return response.json();
                }
            })
            .then((data) => {
                if ('reserved' === button.dataset.type) {
                    console.log(button.dataset.id);
                    document.querySelector(`#reserved-product-button-${button.dataset.id}`).hidden = true
                    document.querySelector(`#unreserved-product-button-${button.dataset.id}`).hidden = false
                    document.querySelector(`#buy-button-${button.dataset.id}-container`).innerHTML = data.buyButton;
                    this.initBuyButton();
                } else if ('unreserved' === button.dataset.type) {
                    console.log(button.dataset.id);
                    document.querySelector(`#reserved-product-button-${button.dataset.id}`).hidden = false
                    document.querySelector(`#unreserved-product-button-${button.dataset.id}`).hidden = true
                    document.querySelector(`#buy-button-${button.dataset.id}-container`).innerHTML = '';
                } else if ('buy' === button.dataset.type) {
                    document.querySelector(`#unreserved-product-button-${button.dataset.id}`).hidden = true
                    document.querySelector(`#buy-product-button-${button.dataset.id}`).hidden = true
                    document.querySelector(`#unbuy-product-button-${button.dataset.id}`).hidden = false
                } else if ('unbuy' === button.dataset.type) {
                    console.log(button.dataset.id);
                    document.querySelector(`#unreserved-product-button-${button.dataset.id}`).hidden = false
                    document.querySelector(`#buy-product-button-${button.dataset.id}`).hidden = false
                    document.querySelector(`#unbuy-product-button-${button.dataset.id}`).hidden = true
                }
                button.dataset.listener = 'false';
                makeFlash(data.flash.message, data.flash.type);
            })
    }
}