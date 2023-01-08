
class Maker {
    nodeElementByString(string) {
        const div = document.createElement('div');
        div.innerHTML = string;
        return div.firstElementChild;
    }
    element(tag, text) {
        const  newElement = document.createElement(tag);
        newElement.innerText = text;
        return newElement;
    }
}
export default new Maker();
