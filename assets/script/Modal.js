class Modal {
    constructor() {
        this.body = document.querySelector('#modal-body');
    }
    getFormButton() {
        return this.body.querySelector('button');
    }
    transformFormButton(url) {
        this.getFormButton().type = 'button';
        this.getFormButton().dataset.dismiss= 'modal';
        this.getFormButton().dataset.url= url;
    }
}
export default new Modal();
