import Maker from "./Maker";

class LocationUpdate {
    constructor() {
        document.querySelector('#locationPrincipalButton')?.addEventListener('click', this.onClickUpdateLocationPrincipal);
    }

    onClickUpdateLocationPrincipal(e) {
        e.preventDefault();
        fetch(this.href, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                if (200 === response.status) {
                    this.remove()
                    return response.json()
                }
            })
            .then((data) => {
                Maker.flash(data.message, data.type)
            })
    }
}

new LocationUpdate();