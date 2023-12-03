import {multiselector, config_multiselector} from "./multiselector.js";

config_multiselector();
const form = document.querySelector('form');
console.log('form');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    multiselector('','#assigns');
    multiselector('','#tags');
    form.submit();
});