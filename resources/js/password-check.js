document.addEventListener('DOMContentLoaded', () => {

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const checklist = document.getElementById('password-checklist');
    const submitBtn = document.getElementById('submit-btn');
    const matchMessage = document.getElementById('password-match-message');

    if (!passwordInput || !checklist || !submitBtn) return;

    const rules = {
        length: document.getElementById('rule-length'),
        uppercase: document.getElementById('rule-uppercase'),
        number: document.getElementById('rule-number'),
        symbol: document.getElementById('rule-symbol'),
    };

    function validate() {
        const value = passwordInput.value;
        const confirmValue = confirmInput ? confirmInput.value : '';

        if (value.length > 0) {
            checklist.classList.remove('hidden');
            setTimeout(() => checklist.classList.remove('opacity-0'), 10);
        } else {
            checklist.classList.add('opacity-0');
            setTimeout(() => checklist.classList.add('hidden'), 300);
        }

        const validations = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            number: /[0-9]/.test(value),
            symbol: /[^A-Za-z0-9]/.test(value),
        };

        toggleRule(rules.length, validations.length);
        toggleRule(rules.uppercase, validations.uppercase);
        toggleRule(rules.number, validations.number);
        toggleRule(rules.symbol, validations.symbol);

        const passwordValid = Object.values(validations).every(Boolean);

        let confirmValid = true;

        if (confirmInput) {
            if (confirmValue.length > 0 && value !== confirmValue) {
                confirmValid = false;
                matchMessage.textContent = 'As senhas não coincidem';
                matchMessage.classList.remove('hidden');
            } else {
                matchMessage.classList.add('hidden');
            }
        }

        submitBtn.disabled = !(passwordValid && confirmValid);
    }

    passwordInput.addEventListener('input', validate);
    if (confirmInput) confirmInput.addEventListener('input', validate);

    function toggleRule(element, valid) {
        if (!element) return;

        const iconContainer = element.querySelector('.icon');

        if (valid) {
            element.style.color = '#34d399';
            iconContainer.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    style="fill:#34d399;">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                </svg>
            `;
        } else {
            element.style.color = '#9ca3af';
            iconContainer.innerHTML = `
                <span style="
                    display:inline-block;
                    width:8px;
                    height:8px;
                    border-radius:999px;
                    background:#6b7280;
                "></span>
            `;
        }
    }

});