const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('keydown', (e) => {
    if(e.key!=='Enter') return;
    const form = document.querySelector('#search');
    form.submit();
});
