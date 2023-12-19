const searchbar = document.querySelector('#search-bar');
const form = document.querySelector('#search')
searchbar.addEventListener('keydown',(e)=>{
    if(e.key!== 'Enter') return;
    form.submit();
})