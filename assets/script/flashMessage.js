export function makeFlash(message, type) {
    const flashBox = document.querySelector('.flash');
    let flashCard = flashBox.dataset.flashCardTemplate;
    flashCard = flashCard.replace('__message__', message);
    flashCard = flashCard.replace('__type__', type);
    flashBox.innerHTML = flashCard;
    flashBox.style.animation = 'none';
    flashBox.offsetHeight;
    flashBox.style.animation = null;
}
