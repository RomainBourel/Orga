import {makeFlash} from "./flashMessage";
class LocationUpdate {
    constructor() {
        document.querySelector('#locationPrincipalButton')?.addEventListener('click', this.onClickUpdateLocationPrincipal);
    }

    onClickUpdateLocationPrincipal(e) {
        e.preventDefault();
        console.log(this.href)
        fetch(this.href, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                console.log(response.status)
                if (200 === response.status) {
                    this.remove()
                    return response.json()
                }
            })
            .then((data) => {
                makeFlash(data.message, data.type)
            })
    }
}

new LocationUpdate();