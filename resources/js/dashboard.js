window.scrollCarousel = function(direction) {
    const container = document.getElementById('carousel');
    container.scrollBy({ left: direction * 300, behavior: 'smooth' });
}

window.scrollTopRated = function(direction) {
    const container = document.getElementById('toprated-carousel');
    container.scrollBy({ left: direction * 300, behavior: 'smooth' });
}

window.scrollUpcoming = function(direction) {
    const container = document.getElementById('upcoming-carousel');
    container.scrollBy({ left: direction * 500, behavior: 'smooth' });
}

window.searchBar = function() {
    return {
        query: '',
        results: [],
        loading: false,
        async search() {
            if (this.query.length < 2) { this.results = []; return; }
            this.loading = true;
            const res = await fetch(`/movies/search?q=${encodeURIComponent(this.query)}`);
            this.results = await res.json();
            this.loading = false;
        },
        goToFirst() {
            if (this.results.length > 0) {
                window.location.href = `/movies/tmdb/${this.results[0].id}`;
            }
        },
        close() {
            this.results = [];
        }
    }
}