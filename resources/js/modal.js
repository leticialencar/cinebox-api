document.addEventListener('DOMContentLoaded', function () {

    const openModalBtn = document.getElementById('openModal');
    const closeModalBtn = document.getElementById('closeModal');
    const closeModalBtn2 = document.getElementById('closeModalBtn');
    const modal = document.getElementById('ratingModal');
    const ratingInput = document.getElementById('ratingInput');

    const originalRating = ratingInput ? ratingInput.value : 0;

    if (openModalBtn) {
        openModalBtn.addEventListener('click', function () {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
        });
    }

    function closeModal() {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');

        if (ratingInput) {
            ratingInput.value = originalRating;

            const starContainer = document.getElementById('starContainer');
            if (starContainer) {
                starContainer.dispatchEvent(new Event('mouseleave'));
            }
        }
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (closeModalBtn2) closeModalBtn2.addEventListener('click', closeModal);

});