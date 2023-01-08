import Maker from '../Maker.js';
class PropositionDate {
    constructor() {
        this.id = 0;
        document.querySelector(`#add-proposition-date`).addEventListener('click', this.onClickAddPropositionDate);
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
        this.createPropositionDateForm();
    }

    createPropositionDateForm() {
        this.getList().append(this.getFormTemplate());
    }
}
export default new PropositionDate();
