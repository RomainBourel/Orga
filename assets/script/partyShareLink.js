import {makeFlash} from "./flashMessage";
import Maker from "./Maker";
class PartyShareLink {
    constructor() {
        this.partyShareButton = document.querySelector('#party-share-button');
        this.partyShareButton.addEventListener('click', this.onClickCallLink);
    }

    onClickCallLink = (e) => {
        e.preventDefault();
        this.callLink(this.partyShareButton.href);
    }

    onClickCreateNewLink = (e) => {
        e.preventDefault();
        this.callLink(this.partyShareNewButton.href, true);
    }

    callLink(url, newLink = false) {
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
                if (newLink) {
                    document.querySelector('#party-share-link').value = data.link;
                    makeFlash(data.flash.message, data.flash.type);
                    return;
                }
                document.querySelector('#party-share').innerHTML = data.template;
                this.partyShareNewButton = document.querySelector('#party-share-new');
                this.partyShareNewButton.addEventListener('click', this.onClickCreateNewLink);
                document.querySelector('#copy-button').addEventListener('click', (e) => {this.onClickCopyLink(e, data.flash)});
            })
    }

    onClickCopyLink(e, flash) {
        navigator.clipboard.writeText(document.querySelector('#party-share-link').value);
        makeFlash(flash.message, flash.type);
    }
}

new PartyShareLink();