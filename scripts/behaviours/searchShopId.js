initALL();

$( document ).ready(function () {




});

function getSearchResult(url , id , element) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(element);
            element.html("");
            element.append(this.responseText);
            initALL();
        }
    };
    xhttp.open("GET", url+"?orderId="+id, true);
    xhttp.send();
}

function load_search_requests(id){

    $(".js-to-search").each(function () {

        $(this).html("loading...     <div class='loader'></div>");

        getSearchResult($(this).data("geturl") , id , $(this));

    });

}

function initSearchShop() {

    $(".dark-background").click(function () {
        $(".search-results").toggleClass("active");
        $(".dark-background").toggleClass("active");
    });

    $(".search-button").click(function () {

        load_search_requests($(".js-search-input").val());

        $(".search-results").addClass("active");
        $(".dark-background").addClass("active");

    });

}



