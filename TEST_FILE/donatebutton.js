document.querySelectorAll('.donate').forEach(function(elem) {

    const inputElement = elem.querySelector('input');
    const form = elem.querySelector('form');

    const input = SimpleMaskMoney.setMask(inputElement, {
        prefix: '$',
        fixed: true,
        fractionDigits: 2,
        decimalSeparator: ',',
        thousandsSeparator: '.'
    });

    form.addEventListener('submit', e => {
        e.preventDefault();
        elem.classList.add('submit');
        setTimeout(() => {
            elem.classList.remove('submit');
        }, 1500); // Adjust the timeout to match the animation duration
    });

    document.addEventListener('click', e => {
        if(e.target === form || form.contains(e.target)) {
            return;
        }
        if(e.target === elem || elem.contains(e.target)) {
            if(!elem.classList.contains('submit')) {
                if(elem.classList.contains('open')) {
                    elem.classList.add('submit');
                    setTimeout(() => {
                        elem.classList.remove('submit');
                    }, 1500); // Adjust the timeout to match the animation duration
                } else {
                    elem.classList.add('open');
                    setTimeout(() => {
                        inputElement.selectionStart = inputElement.selectionEnd = 10000;
                        inputElement.focus();
                    }, 0);
                }
            }
            return;
        }
        if(!elem.classList.contains('submit')) {
            elem.classList.remove('open');
        }
    });

    // Ensure the button click triggers the form submit event
    elem.querySelector('button').addEventListener('click', (e) => {
        e.preventDefault();
        form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
    });

    // Ensure the animation class is removed after the animation ends
    elem.querySelector('button').addEventListener('animationend', () => {
        elem.classList.remove('submit');
    });

});
