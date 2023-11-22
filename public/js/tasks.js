const currentPath = window.location.pathname;
const editPage = /^\/tasks\/[0-9]+\/edit$/.test(currentPath);
const searchPage = /^[/\w, \/]*\/search*$/.test(currentPath);

const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('input', (e) => {
    let $input = searchBar.value;
    request($input);
});
async function request(input) {

    return await fetch('/tasks/search?searchTerm=' + input, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then(function (response) {

            return response.text()
        })
        .then(function (html) {
            const container = document.getElementsByClassName('tasks')[0];
            console.log(container);
            container.innerHTML = html;

        })
        .catch(function (err) {
            console.log('Failed to fetch page: ', err);
        });
}

