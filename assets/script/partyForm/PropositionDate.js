import Maker from '../Maker.js';
class PropositionDate {
    constructor() {
        this.id = 0;
        if (null === document.querySelector('[id^=party_form_propositionDates_]')) {
            this.createPropositionDateForm();
        }
        this.buttonAddPropositionDate = document.querySelector(`#add-proposition-date`);
        this.buttonAddPropositionDate.addEventListener('click', this.onClickAddPropositionDate);
    }

    getList() {
        return document.querySelector('#proposition-date-list');
    }
    getFormTemplate() {
        const formTemplate = Maker.nodeElementByString(this.getList().dataset.template.replace(/__name__/g, this.id++));
        formTemplate.classList.add('form__section')
        return formTemplate;
    }

    onClickAddPropositionDate = (e) => {
        if ('false' === this.buttonAddPropositionDate.dataset.listener) {
            this.buttonAddPropositionDate.dataset.listener = "true";
            this.updateTextButton();
        }
        this.createPropositionDateForm();
    }

    updateTextButton() {
        this.buttonAddPropositionDate.innerText = this.buttonAddPropositionDate.dataset.addPropositionText;
    }
    createPropositionDateForm() {
        this.getList().append(this.getFormTemplate());
    }
}
export default new PropositionDate();
