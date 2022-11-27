const passwordInputs = document.querySelectorAll('[type="password"]');
passwordInputs.forEach(initPswInputAddOn);

function addToggleTypeButton(input) {
    const eyeButton = makeEyeButton();
    input.parentElement.style.position = 'relative';
    input.parentElement.append(eyeButton);
    eyeButton.addEventListener('click', onClickSwitchPswVisibility.bind(input));
}

function makeEyeButton() {
    const eyeButton = document.createElement('button');
    eyeButton.type = 'button';
    eyeButton.classList.add('btn', 'btn__eye');
    return eyeButton;
}

function onClickSwitchPswVisibility() {
    this.type = this.type === 'password' ? 'text' : 'password';
}

function initPswInputAddOn(input) {
    addToggleTypeButton(input);
    passwordChecker(input);
}

function passwordChecker(input) {
    if (document.querySelector('[data-clue]')) {
        if (input.dataset.principal) {
            input.addEventListener('keyup', onKeyupCheckPasswordValid)
        } else {
            input.addEventListener('keyup', onKeyupCheckSamePassword)
        }
    }
}

function makeCheck(dataValue) {
    const check = document.createElement('p');
    check.classList.add('icon__check', 'icon__check--psw-input');
    check.innerText = '✔';
    check.dataset.check = dataValue;
    return check;
}

function onKeyupCheckPasswordValid() {
    let value = this.value;
    let isValid = matchUppercase(value);
    isValid = matchLowercase(value) && isValid;
    isValid = matchDigit(value) && isValid;
    isValid = matchSpChar(value) && isValid;
    isValid = checkLength(value) && isValid;

    if (isValid) {
        if (!document.querySelector('[data-check="1"]')) {
            this.parentElement.append(makeCheck('1'));
        }
    } else {
        document.querySelectorAll('[data-check]').forEach(element => element.remove());
    }
    onKeyupCheckSamePassword();
}

function matchUppercase(value) {
    return match(value, /[A-Z]/g, 'uppercase')
}
function matchLowercase(value) {
    return match(value, /[a-z]/g, 'lowercase')
}
function matchDigit(value) {
    return match(value, /[0-9]/g, 'int')
}
function matchSpChar(value) {
    return match(value, /[^a-zA-Z0-9]/g, 'sp')
}

function match(value, regex, name) {
    if (value.match(regex)) {
        toggleCheckIcon(name, true);
        return true;
    }
    toggleCheckIcon(name, false);
    return false
}

function checkLength(value) {
    if (10 <= value.length) {
        toggleCheckIcon('length', true);
        return true;
    }
    toggleCheckIcon('length', false);
    return false
}

function toggleCheckIcon(name, isValid) {
    const clue = document.querySelector(`[data-clue="${name}"]`);
    clue.className = isValid ? 'icon__check' : 'icon__cross';
    clue.textContent = isValid ? '✔' : '✖';
}

function onKeyupCheckSamePassword() {
 if ( passwordInputs[0].value === passwordInputs[1].value && document.querySelector(`[data-check]`)) {
        passwordInputs[1].parentElement.append(makeCheck('2'));
    } else {
        document.querySelector('[data-check="2"]')?.remove();
    }
}