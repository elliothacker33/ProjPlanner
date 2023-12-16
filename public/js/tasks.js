import {sendAjaxRequest, encodeForAjax} from './app.js'
import {icons} from "./const/icons.js";

const currentPath = window.location.pathname;

const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('keydown', (e) => {
    if(e.key!=='Enter') return;
    const form = document.querySelector('#search');
    form.submit();
});