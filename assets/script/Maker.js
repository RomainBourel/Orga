export default class Maker {
    static nodeElementByString(string) {
        const div = document.createElement('div');
        div.innerHTML = string;
        return div.firstElementChild;
    }
    static element(tag, text, className = []) {
        const  newElement = document.createElement(tag);
        newElement.innerText = text;
        newElement.classList.add(...className);
        return newElement;
    }

    static flash(message, type) {
        const flashBox = document.querySelector('.flash');
        let flashCard = flashBox.dataset.flashCardTemplate;
        flashCard = flashCard.replace('__message__', message);
        flashCard = flashCard.replace('__type__', type);
        flashBox.innerHTML = flashCard;
        flashBox.style.animation = 'none';
        flashBox.offsetHeight;
        flashBox.style.animation = null;
    }
}
