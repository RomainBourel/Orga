import Maker from "./Maker";

/**
 * This class is used to call a link with fetch and replace the text of the link.
 * The link must have the data-fetch-link="true" attribute
 */
export default class LinkAssync {
    constructor() {
        this.fetchLinks = document.querySelectorAll('[data-fetch-link="true"]');
        this.bindLinks();
    }

    bindLinks()
    {
        this.fetchLinks.forEach((link) => {
            link.addEventListener('click', (e) => {this.onClickCallLink(e, link)});
        });
    }

    onClickCallLink = (e, link) => {
        e.preventDefault();
        link.dataset.fetchLink = 'false';
        this.callLink(link.href, link);
    }

    callLink(url, link) {
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
                if (data.flash) {
                    Maker.flash(data.flash.message, data.flash.type);
                }

                if (data.newText) {
                    link.innerText = data.newText;
                }
            })
    }
}