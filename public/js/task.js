import {multiselector} from "./multiselector.js";


const form = document.querySelector('form');
console.log('form');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    multiselector('','#assigns');
    form.submit();
});