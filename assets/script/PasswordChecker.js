class PasswordChecker {
    constructor() {
        this.passwordInputs = document.querySelectorAll('[type="password"]');
        this.passwordInputs.forEach(input => this.initPswInputAddOn(input));
    }

    addToggleEyeButton(input) {
        const eyeButton = this.makeEyeButton();
        input.parentElement.style.position = 'relative';
        input.parentElement.append(eyeButton);
        eyeButton.addEventListener('click', () => this.onClickSwitchPswVisibility(input));
    }

    makeEyeButton() {
        const eyeButton = document.createElement('div');
        eyeButton.innerHTML = document.querySelector('#eye-template').innerHTML;
        return eyeButton;
    }

    onClickSwitchPswVisibility(input) {
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    initPswInputAddOn(input) {
        this.addToggleEyeButton(input);
        this.passwordChecker(input);
    }

    passwordChecker(input) {
        if (document.querySelector('[data-clue]')) {
            if (input.dataset.principal) {
                input.addEventListener('keyup', this.onKeyupCheckPasswordValid);
                input.addEventListener('blur', this.onKeyupCheckPasswordValid);
            } else {
                input.addEventListener('keyup', this.onKeyupCheckSamePassword);
                input.addEventListener('blur', this.onKeyupCheckSamePassword);
            }
        }
    }

    makeCheck(dataValue) {
        const check = document.createElement('p');
        check.classList.add('icon__check', 'icon__check--psw-input');
        check.innerText = '✔';
        check.dataset.check = dataValue;
        return check;
    }

    onKeyupCheckPasswordValid = ({target}) => {
        const value = target.value;
        let isValid = this.matchUppercase(value);
        isValid = this.matchLowercase(value) && isValid;
        isValid = this.matchDigit(value) && isValid;
        isValid = this.matchSpChar(value) && isValid;
        isValid = this.checkLength(value) && isValid;

        if (isValid) {
            if (!document.querySelector('[data-check="1"]')) {
                target.parentElement.append(this.makeCheck('1'));
            }
        } else {
            document.querySelectorAll('[data-check]').forEach(element => element.remove());
        }
        this.onKeyupCheckSamePassword();
    }

    matchUppercase(value) {
        return this.match(value, /[A-Z]/g, 'uppercase');
    }

    matchLowercase(value) {
        return this.match(value, /[a-z]/g, 'lowercase');
    }

    matchDigit(value) {
        return this.match(value, /[0-9]/g, 'int');
    }

    matchSpChar(value) {
        return this.match(value, /[^a-zA-Z0-9]/g, 'sp');
    }

    match(value, regex, name) {
        if (value.match(regex)) {
            this.toggleCheckIcon(name, true);
            return true;
        }
        this.toggleCheckIcon(name, false);
        return false
    }

    checkLength(value) {
        if (10 <= value.length) {
            this.toggleCheckIcon('length', true);
            return true;
        }
        this.toggleCheckIcon('length', false);
        return false
    }

    toggleCheckIcon(name, isValid) {
        const clue = document.querySelector(`[data-clue="${name}"]`);
        clue.className = isValid ? 'icon__check' : 'icon__cross';
        clue.textContent = isValid ? '✔' : '✖';
    }

    onKeyupCheckSamePassword = () => {
        if (this.passwordInputs[0].value === this.passwordInputs[1].value && document.querySelector(`[data-check='1']`)) {
            this.passwordInputs[1].parentElement.append(this.makeCheck('2'));
        } else {
            document.querySelector('[data-check="2"]')?.remove();
        }
    }
}

new PasswordChecker();
