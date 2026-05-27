document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.getElementById('sortSelect');
    if (!sortSelect) return;

    const grid = document.getElementById('movieGrid');
    const list = document.getElementById('movieList');

    const originalGrid = Array.from(grid.querySelectorAll('.movie-card'));
    const originalList = Array.from(list.querySelectorAll('.movie-card'));

    sortSelect.addEventListener('change', () => {
        sortMovies(sortSelect.value);
    });

    function sortMovies(criteria) {
        [
            { container: grid, original: originalGrid },
            { container: list, original: originalList }
        ].forEach(({ container, original }) => {

            let cards;

            if (criteria === 'recent') {
                cards = [...original]; 
            } else {
                cards = Array.from(container.querySelectorAll('.movie-card'));

                cards.sort((a, b) => {
                    if (criteria === 'title') {
                        return a.dataset.title.localeCompare(b.dataset.title);
                    }
                    if (criteria === 'rating') {
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    }
                    if (criteria === 'year') {
                        return parseInt(b.dataset.year || 0) - parseInt(a.dataset.year || 0);
                    }
                });
            }

            cards.forEach(card => container.appendChild(card));
        });
    }
});