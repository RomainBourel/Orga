export function makeFlash(message, type) {
    const flash = document.createElement('div');
    flash.classList.add('alert', `alert-${type}`);
    flash.innerText = message;
    flash.style.position = 'absolute';
    flash.style.width = '100%';
    flash.style.textAlign = 'center';
    document.querySelector('body').append(flash);
    setTimeout(() => flash.remove(), 4000)
    const transform = [
        { transform: 'translateY(0px)' },
        { transform: 'translateY(-100px)' }
    ];

    const timing = {
        duration: 700,
        iterations: 1,
        fill: 'forwards',
        delay: 2000,
        easing: 'ease-in',
    }
    flash.animate(transform, timing);
}
