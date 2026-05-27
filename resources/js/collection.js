let currentFilter = 'all';

function filterBy(filter) {
    currentFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const isActive = btn.dataset.filter === filter;
        btn.className = isActive
            ? 'filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-[#8042e8]/40 bg-[#8042e8]/10 text-[#a060ff]'
            : 'filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-white';
    });
    applyFilters();
}

function applyFilters() {
    const query = document.getElementById('searchInput')?.value.toLowerCase() ?? '';
    const cards = document.querySelectorAll('.movie-card');
    let visible = 0;

    cards.forEach(card => {
        const matchSearch = (card.dataset.title ?? '').includes(query);
        const matchFilter =
            currentFilter === 'all' ||
            (currentFilter === 'rated'    && card.dataset.rated    === 'true') ||
            (currentFilter === 'unrated'  && card.dataset.rated    === 'false') ||
            (currentFilter === 'favorite' && card.dataset.favorite === 'true');

        const show = matchSearch && matchFilter;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('emptySearch')?.classList.toggle('hidden', visible > 0);
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    filterBy('all');
}

function setView(view) {
    const grid    = document.getElementById('movieGrid');
    const list    = document.getElementById('movieList');
    const gridBtn = document.getElementById('gridView');
    const listBtn = document.getElementById('listView');

    const active   = 'view-btn p-2.5 rounded-lg border border-[#8042e8]/40 bg-[#8042e8]/10 text-[#a060ff] transition';
    const inactive = 'view-btn p-2.5 rounded-lg border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-white transition';

    if (view === 'grid') {
        grid?.classList.remove('hidden');
        list?.classList.add('hidden'); 
        list?.classList.remove('flex');
        gridBtn.className = active; 
        listBtn.className = inactive;
    } else {
        list?.classList.remove('hidden'); 
        list?.classList.add('flex');
        grid?.classList.add('hidden');
        listBtn.className = active; 
        gridBtn.className = inactive;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('searchInput')?.addEventListener('input', applyFilters);
    document.getElementById('sortSelect')?.addEventListener('change', applyFilters);
});

window.filterBy = filterBy;
window.resetFilters = resetFilters;
window.setView = setView;