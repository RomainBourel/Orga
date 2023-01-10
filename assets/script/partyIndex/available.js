import {makeFlash} from "../flashMessage";
export default class Available {
    constructor() {
        this.partyAvailableButton = document.querySelectorAll('[id^=party-available-button-]');
        this.partyUnavailableButton = document.querySelectorAll('[id^=party-unavailable-button-]');
        this.init();
    }

    init()
    {
        this.partyAvailableButton.forEach((button) => {
            button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
        });
        this.partyUnavailableButton.forEach((button) => {
            button.addEventListener('click', (e) => {this.onClickCallLink(e, button)});
        });

    }
    onClickCallLink = (e, button) => {
        e.preventDefault();
        if ('false' === button.dataset.listener) {
            this.callLink(button.href, button.dataset.id, button);
            button.dataset.listener = 'true';
        } else {
            this.callLink(button.href, button.dataset.id);
        }

    }

    callLink(url, id) {
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

                document.querySelector(`#party-available-button-${id}`).hidden = data.isAvailable
                document.querySelector(`#party-unavailable-button-${id}`).hidden = !data.isAvailable
                if (data.isAvailable) {
                    this.borderStyle = 'mediumseagreen 2px solid';
                } else {
                    this.borderStyle = 'grey 1px solid';
                }
                document.querySelector(`#card-proposition-date-${id}`).style.border = this.borderStyle;
                makeFlash(data.flash.message, data.flash.type);
            })
    }
}