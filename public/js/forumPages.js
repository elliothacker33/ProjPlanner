function loadPosts(page) 
{

    $.ajax({
        url:'?page=' + page,
        type: 'get',
    })
    .done (function(data) {
        return;
    })
    .fail(function() {
        alert('Posts could not be loaded.');
    });

}

let page = 1;

$(window).scroll(function() {

    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadPosts(page);
    }

});