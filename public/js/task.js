import {config_multiselector, multiselector} from "./components/multiselector.js";

config_multiselector();
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    multiselector('.users', '#assigns');
    multiselector('.tags', '#tags');
    form.submit();
});