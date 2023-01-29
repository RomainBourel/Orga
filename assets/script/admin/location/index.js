document.querySelectorAll('[data-toggle-url]').forEach((toggle) => {
    toggle.addEventListener("click", function() {
        const sameUserToggle = document.querySelectorAll(`[data-user-id="${this.dataset.userId}"]`);
        sameUserToggle.forEach((toggle) => {
            if (toggle !== this) {
                toggle.checked = false;
            }
        });
    })
});