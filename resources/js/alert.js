document.addEventListener('DOMContentLoaded', () => {
    ['alert', 'alert-mobile'].forEach(id => {
        const alertBox = document.getElementById(id);
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transform = 'translateX(0)';
                alertBox.style.opacity = '1';
            }, 100);

            setTimeout(() => {
                alertBox.style.transform = 'translateX(20px)';
                alertBox.style.opacity = '0';
            }, 3500);

            setTimeout(() => {
                alertBox.remove();
            }, 4000);
        }
    });
});