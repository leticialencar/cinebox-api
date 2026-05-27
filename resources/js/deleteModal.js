const openDeleteBtn    = document.getElementById('openDeleteModal');
const deleteModal      = document.getElementById('deleteModal');
const cancelDeleteBtn  = document.getElementById('cancelDeleteModal');
const confirmDeleteBtn = document.getElementById('confirmDelete');
const deleteForm       = document.getElementById('deleteMovieForm');

function openDeleteModal() {
    deleteModal.classList.remove('opacity-0', 'pointer-events-none');
}

function closeDeleteModal() {
    deleteModal.classList.add('opacity-0', 'pointer-events-none');
}

openDeleteBtn?.addEventListener('click', openDeleteModal);
cancelDeleteBtn?.addEventListener('click', closeDeleteModal);

deleteModal?.addEventListener('click', function (e) {
    if (e.target === deleteModal) closeDeleteModal();
});

confirmDeleteBtn?.addEventListener('click', function () {
    deleteForm.submit();
});