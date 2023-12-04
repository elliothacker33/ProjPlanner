
const searchBar = document.getElementById('search-bar');
searchBar.addEventListener('input', (e) => {
    let $input = searchBar.value;
    request($input);
});
console.log(0)
async function request(input) {

    return await fetch(currentPath+'/search?searchTerm=' + input, {
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
            container.innerHTML = html;
        })
        .catch(function (err) {
            console.log('Failed to fetch page: ', err);
        });
}

