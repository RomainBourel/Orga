
class Maker {
    nodeElementByString(string) {
        const div = document.createElement('div');
        div.innerHTML = string;
        return div.firstElementChild;
    }
    element(tag, text, className = []) {
        const  newElement = document.createElement(tag);
        newElement.innerText = text;
        newElement.classList.add(...className);
        return newElement;
    }
}
export default new Maker();
