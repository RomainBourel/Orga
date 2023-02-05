import Maker from '../Maker.js';
export default class PropositionDate {
    constructor() {
        this.id = document.querySelector('#proposition-date-list').dataset.currentId;
        this.buttonAddPropositionDate = document.querySelector(`#add-proposition-date`);
        this.list = document.querySelector('#proposition-date-list');
        this.defaultDate = this.list.dataset.defaultDate;
        this.init();
    }

    init() {
        if (null === document.querySelector('[id^=party_form_propositionDates_]')) {
            this.createPropositionDateForm();
        }
        this.buttonAddPropositionDate.addEventListener('click', this.onClickAddPropositionDate);
        this.initPropositionDates();
    }

    initPropositionDates() {
        document.querySelectorAll('[data-proposition-date-remove]').forEach((button, key) => {
            if (0 === key) {
                button.parentElement.parentElement.classList.add('hidden');
            } else {
                button.addEventListener('click', this.onClickRemovePropositionDate);
            }
            button.parentElement.parentElement.parentElement.classList.add('form__section');
        });
    }

    onClickRemovePropositionDate = ({target}) => {
        const propositionDate = target.parentElement.parentElement.parentElement;
        propositionDate.classList.add('hidden');
        propositionDate.querySelector(`[id$="startingAt"]`).value = this.defaultDate;
    }

    getFormTemplate() {
        const formTemplate = Maker.nodeElementByString(this.list.dataset.template.replace(/__name__/g, this.id++));
        formTemplate.classList.add('form__section')
        formTemplate.querySelector('[data-proposition-date-remove]').addEventListener('click', this.onClickRemovePropositionDate);
        return formTemplate;
    }

    onClickAddPropositionDate = () => {
        if ('true' !== this.buttonAddPropositionDate.dataset.listener) {
            this.buttonAddPropositionDate.dataset.listener = 'true';
            this.updateTextButton();
        }
        this.createPropositionDateForm();
    }

    updateTextButton() {
        this.buttonAddPropositionDate.innerText = this.buttonAddPropositionDate.dataset.addPropositionText;
    }
    createPropositionDateForm() {
        this.list.append(this.getFormTemplate());
    }
}
